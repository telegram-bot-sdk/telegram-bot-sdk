<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Traits\HasUpdate;

/**
 * Class Parser
 */
class Parser
{
    use HasUpdate;

    /** @var MessageEntity|null Details of the current entity this command is responding to - offset, length, type etc */
    protected ?MessageEntity $entity = null;

    /** @var CommandInterface|string */
    protected $command;

    /** @var Collection|null Hold command params */
    protected ?Collection $params = null;

    /**
     * @param CommandInterface|string $command
     *
     * @return Parser
     */
    public static function parse($command): self
    {
        return (new static())->setCommand($command);
    }

    /**
     * @return CommandInterface|string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param CommandInterface|string $command
     *
     * @return $this
     */
    public function setCommand($command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getEntity(): ?MessageEntity
    {
        return $this->entity;
    }

    public function setEntity(MessageEntity $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Parse Command Arguments.
     *
     * @throws TelegramCommandException|TelegramSDKException
     * @return array
     */
    public function arguments(): array
    {
        preg_match(
            $this->argumentsPattern(),
            $this->relevantSubString(Entity::from($this->getUpdate())->text()),
            $matches
        );

        return $this->nullifiedRegexParams()
            // Discard non-named key-value pairs and merge with nullified regex params.
            ->merge(array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY))
            ->all();
    }

    /**
     * Get all command handle params except type-hinted classes.
     *
     * @throws TelegramCommandException
     *
     * @return Collection
     */
    public function allParams(): Collection
    {
        if (null !== $this->params) {
            return $this->params;
        }

        try {
            $handle = new ReflectionMethod($this->command, 'handle');
        } catch (ReflectionException $e) {
            throw TelegramCommandException::commandMethodDoesNotExist($e);
        }

        return $this->params = collect($handle->getParameters())
            ->reject(fn (ReflectionParameter $param) => $param->getClass());
    }

    /**
     * Get all REQUIRED params of a command handle.
     *
     * @throws TelegramCommandException
     * @return Collection
     */
    public function requiredParams(): Collection
    {
        return $this->allParams()
            ->reject(fn ($parameter): bool => $parameter->isDefaultValueAvailable() || $parameter->isVariadic())
            ->pluck('name');
    }

    /**
     * Get params that are required but have not been provided.
     *
     * @param array $params
     *
     * @throws TelegramCommandException
     * @return Collection
     */
    public function requiredParamsNotProvided(array $params): Collection
    {
        return $this->requiredParams()->diff($params)->values();
    }

    /**
     * Get Nullified Regex Params.
     *
     * @throws TelegramCommandException
     * @return Collection
     */
    public function nullifiedRegexParams(): Collection
    {
        return $this->allParams()
            ->filter(fn (ReflectionParameter $param): bool => $this->isRegexParam($param))
            ->mapWithKeys(fn (ReflectionParameter $param): array => [$param->getName() => null]);
    }

    /**
     * Make command arguments regex pattern.
     *
     * @throws TelegramCommandException
     * @return string
     */
    protected function argumentsPattern(): string
    {
        $pattern = $this->allParams()->map(function (ReflectionParameter $param): string {
            $regex = $this->isRegexParam($param)
                ? self::between($param->getDefaultValue(), '{', '}')
                : '[^ ]++';

            return sprintf('(?P<%s>%s)?', $param->getName(), $regex);
        })->implode('(?:\s+)?');

        // Ex: /start@Somebot <arg> ...<arg>
        // Ex: /start <arg> ...<arg>
        return "%/[\w]+(?:@.+?bot)?(?:\s+)?{$pattern}%si";
    }

    /**
     * Determine if its a regex parameter.
     *
     * @param ReflectionParameter $param
     *
     * @throws ReflectionException
     * @return bool
     */
    protected function isRegexParam(ReflectionParameter $param): bool
    {
        return $param->isDefaultValueAvailable() && Str::is('{*}', $param->getDefaultValue());
    }

    /**
     * @param string $fullString
     *
     * @throws TelegramSDKException
     *
     * @return string
     */
    private function relevantSubString(string $fullString): string
    {
        $commandOffsets = $this->allCommandOffsets();

        //Find the start point for this command and, if it exists, the start point (offset) of the NEXT bot_command entity
        $splicePoints = $commandOffsets->splice(
            $commandOffsets->search($this->getEntity()['offset']),
            2
        );

        return $splicePoints->count() === 2
            ? $this->cutTextBetween($splicePoints, $fullString)
            : $this->cutTextFrom($splicePoints, $fullString);
    }

    private function cutTextBetween(Collection $splicePoints, string $fullString): string
    {
        return mb_substr(
            $fullString,
            $splicePoints->first(),
            $splicePoints->last() - $splicePoints->first(),
            'UTF-8'
        );
    }

    private function cutTextFrom(Collection $splicePoints, string $fullString): string
    {
        return mb_substr($fullString, $splicePoints->first(), null, 'UTF-8');
    }

    /**
     * @throws TelegramSDKException
     * @return Collection
     */
    private function allCommandOffsets(): Collection
    {
        return Entity::from($this->getUpdate())->commandEntities()->pluck('offset');
    }

    /**
     * Get the portion of a string between a given values.
     *
     * @param string $subject
     * @param string $before
     * @param string $after
     *
     * @return string
     */
    public static function between(string $subject, string $before, string $after): string
    {
        if ($before === '' || $after === '') {
            return $subject;
        }

        return Str::beforeLast(Str::after($subject, $before), $after);
    }
}
