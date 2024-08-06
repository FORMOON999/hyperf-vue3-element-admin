<?php

namespace App\Common\Util\IPC\Helper;

use Hyperf\Contract\ConfigInterface;

class SysConfigHelper
{
    public const CONFIG_KEY = 'sysConfig';

    public function __construct(protected ConfigInterface $config)
    {

    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config->get(self::CONFIG_KEY . ".{$key}", []);
    }

    public function has(string $key): bool
    {
        return $this->config->has(self::CONFIG_KEY . ".{$key}");
    }

    public function set(string $key, mixed $value): void
    {
        $this->config->set(self::CONFIG_KEY . ".{$key}", $value);
    }

    public function getAll(): array
    {
        return $this->config->get(self::CONFIG_KEY, []);
    }

    public function key(): string
    {
        return self::CONFIG_KEY;
    }
}