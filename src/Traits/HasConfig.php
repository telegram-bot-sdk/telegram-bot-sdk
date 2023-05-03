<?php

namespace Telegram\Bot\Traits;

use Illuminate\Support\Arr;

trait HasConfig
{
    private array $config;

    /**
     * Check if an option or options exist in config using "dot" notation.
     */
    public function hasConfig($key): bool
    {
        return Arr::has($this->config, $key);
    }

    public function config(array|string|null $key = null, mixed $default = null): mixed
    {
        if (null === $key) {
            return $this->config;
        }

        if (is_array($key)) {
            foreach ($key as $name => $value) {
                Arr::set($this->config, $name, $value);
            }

            return true;
        }

        return Arr::get($this->config, $key, $default);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }
}
