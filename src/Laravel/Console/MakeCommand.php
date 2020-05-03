<?php

namespace Telegram\Bot\Laravel\Console;

use Illuminate\Console\GeneratorCommand;

class MakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'telegram:make:command {name : The name of the bot command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Telegram bot command';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Telegram bot command';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $relativePath = '/stubs/telegram.command.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__ . '/..' . $relativePath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Telegram\Commands';
    }
}
