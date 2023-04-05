<?php

namespace Telegram\Bot\Traits;

use Illuminate\Support\Arr;

/**
 * HasConfig.
 */
trait HasConfig
{
    private array $config;

    /**
     * Check if an option or options exist in config using "dot" notation.
     *
     * @param $key
     */
    public function hasConfig($key): bool
    {
        return Arr::has($this->config, $key);
    }

    /**
     * Get or set configuration value using "dot" notation.
     *
     * @param mixed|null        $default
     * @return mixed
     */
    public function config(array|string|null $key = null, $default = null)
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

    /**
     * Get Config Array.
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set Config Array.
     *
     *
     * @return static
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }
}
