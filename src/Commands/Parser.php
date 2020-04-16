<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionMethod;
use ReflectionParameter;
use Telegram\Bot\Traits\HasUpdate;

class Parser
{
    use HasUpdate;

    /** @var array|null Details of the current entity this command is responding to - offset, length, type etc */
    protected ?array $entity;

    /** @var CommandInterface|string */
    protected $command;

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
     * Get all command handle params except typehinted classes.
     *
     * @throws \ReflectionException
     * @return Collection
     */
    protected function getAllParams(): Collection
    {
        $reflection = new ReflectionMethod($this->command, 'handle');

        // Get all params except typehinted classes.
        return collect($reflection->getParameters())->reject(fn (ReflectionParameter $param) => $param->getClass());
    }

    protected function makeCommandArgumentsPattern(): string
    {
        $pattern = $this->getAllParams()->map(
            static function (ReflectionParameter $param) {
                if ($param->isOptional() && $param->isDefaultValueAvailable()) {
                    if (Str::is('{*}', $param->getDefaultValue())) {
                        return sprintf(
                            '(?:\s+?(?P<%s>%s))?',
                            $param->getName(),
                            Str::between($param->getDefaultValue(), '{', '}')
                        );
                    }

                    return "(?:\s+?(?P<{$param->getName()}>[^ ]++))?";
                }

                return "(?P<{$param->getName()}>[^ ]++)";
            }
        )->implode('');

        $optionalBotName = '(?:@.+?bot)?\s+?';

        return "%/[\w]+{$optionalBotName}{$pattern}%si";
    }

    /**
     * Parse Command Arguments.
     *
     * @throws \ReflectionException
     * @return array
     */
    public function parseCommandArguments(): array
    {
        preg_match($this->makeCommandArgumentsPattern(), $this->relevantMessageSubString(), $matches);
        $regexParams = $this->getNullifiedRegexParams();

        return collect($regexParams)->merge($matches)->all();
    }

    /**
     * @throws \ReflectionException
     * @return array
     */
    protected function getNullifiedRegexParams(): array
    {
        $params = $this->getAllParams()
            ->filter(fn (ReflectionParameter $param) => $param->isDefaultValueAvailable())
            ->filter(fn (ReflectionParameter $param) => Str::is('{*}', $param->getDefaultValue()))
            ->pluck('name')
            ->all();

        return array_fill_keys($params, null);
    }

    /**
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

    private function cutTextBetween(Collection $splice)
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first(),
            $splice->last() - $splice->first()
        );
    }

    private function cutTextFrom(Collection $splice)
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first()
        );
    }

    /**
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
}
