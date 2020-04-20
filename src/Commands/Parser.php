<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\HasUpdate;

class Parser
{
    use HasUpdate;

    /** @var array|null Details of the current entity this command is responding to - offset, length, type etc */
    protected ?array $entity;

    /** @var CommandInterface|string */
    protected $command;

    /** @var Collection|array Hold command params */
    protected $params;

    /**
     * @param $command
     *
     * @return Parser
     */
    public static function parse($command): self
    {
        return (new static())->setCommand($command);
    }

    /**
     * @param $command
     *
     * @return $this
     */
    public function setCommand($command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return CommandInterface|string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param array $entity
     *
     * @return $this
     */
    public function setEntity(array $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getEntity(): ?array
    {
        return $this->entity;
    }

    /**
     * Parse Command Arguments.
     *
     * @throws TelegramCommandException|TelegramSDKException
     * @return array
     */
    public function arguments(): array
    {
        preg_match($this->argumentsPattern(), $this->relevantMessageSubString(), $matches);

        return $this->nullifiedRegexParams()
            // Discard non-named key-value pairs and merge with nullified regex params.
            ->merge(array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY))
            ->all();
    }

    /**
     * Get all command handle params except type-hinted classes.
     *
     * @throws TelegramCommandException
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

        return $this->params = Collection::make($handle->getParameters())
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
     * @throws TelegramSDKException
     * @return bool|string
     */
    private function relevantMessageSubString()
    {
        //Get all the bot_command offsets in the Update object
        $commandOffsets = $this->allCommandOffsets();

        //Extract the current offset for this command and, if it exists, the offset of the NEXT bot_command entity
        $splice = $commandOffsets->splice(
            $commandOffsets->search($this->entity['offset']),
            2
        );

        return $splice->count() === 2 ? $this->cutTextBetween($splice) : $this->cutTextFrom($splice);
    }

    private function cutTextBetween(Collection $splice): string
    {
        return mb_substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first(),
            $splice->last() - $splice->first(),
            'UTF-8'
        );
    }

    private function cutTextFrom(Collection $splice): string
    {
        return mb_substr($this->getUpdate()->getMessage()->text, $splice->first(), null, 'UTF-8');
    }

    /**
     * @throws TelegramSDKException
     * @return Collection
     */
    private function allCommandOffsets(): Collection
    {
        return $this->getUpdate()
            ->getMessage()
            ->entities
            ->filter(fn ($entity) => $entity['type'] === 'bot_command')
            ->pluck('offset');
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
