<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;
use RuntimeException;

class EnvWriter
{
    public function __construct(
        protected string $envFile = '.env'
    ) {}

    public function envFilePath(): string
    {
        return App::environmentPath().DIRECTORY_SEPARATOR.$this->envFile;
    }

    public function setEnvFile(string $value): self
    {
        $this->envFile = $value;

        return $this;
    }

    public function isEnvWritable(): bool
    {
        $path = $this->envFilePath();

        if (! file_exists($path)) {
            if (! is_dir(dirname($path)) || ! is_writable(dirname($path))) {
                return false;
            }

            if (! copy(nova_path('.env.example'), $path)) {
                return false;
            }
        }

        return is_file($path) && is_writable($path);
    }

    /** @param string|array<string, mixed> $key */
    public function set(string|array $key, mixed $value = null): bool
    {
        if (! $this->isEnvWritable()) {
            return false;
        }

        $variables = is_array($key) ? $key : [$key => $value];

        $variables = array_map(fn (mixed $value): mixed => match (true) {
            is_bool($value) => $value ? 'true' : 'false',
            is_null($value) => '',
            default => $value,
        }, $variables);

        set_error_handler(static function (int $severity, string $message): never {
            throw new RuntimeException($message);
        }, E_WARNING);

        try {
            Env::writeVariables($variables, $this->envFilePath(), overwrite: true);
        } catch (RuntimeException|FileNotFoundException) {
            return false;
        } finally {
            restore_error_handler();
        }

        return true;
    }
}
