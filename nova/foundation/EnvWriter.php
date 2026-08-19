<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Dotenv\Dotenv;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;

class EnvWriter
{
    protected string $envFileContents = '';

    public function __construct(
        protected string $envFile = '.env'
    ) {
        $this->loadEnvContent();
    }

    public function envFilePath(): string
    {
        return base_path($this->envFile);
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
            copy(nova_path('.env.example'), $path);

            $this->refreshEnvVars();
        }

        return is_writable($path);
    }

    public function refreshEnvVars(): void
    {
        Dotenv::create(Env::getRepository(), App::environmentPath(), App::environmentFile())->load();
    }

    public function set(string|array $key, mixed $value = null): bool
    {
        if (is_array($key)) {
            return $this->writeMultipleLines($key);
        }

        return $this->writeLine($key, $value);
    }

    public function writeMultipleLines(array $keys = []): bool
    {
        return array_all($keys, fn ($value, string $key): bool => $this->writeLine($key, $value));
    }

    public function writeLine(string $key, mixed $value): bool
    {
        $env = $this->envFileContents;

        $formattedValue = $this->formatValue($value);

        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $env)) {
            $env = preg_replace($pattern, "{$key}={$formattedValue}", $env);
        } else {
            $env .= PHP_EOL."{$key}={$formattedValue}";
        }

        $writeOperation = file_put_contents($this->envFilePath(), trim($env).PHP_EOL) !== false;

        $this->loadEnvContent();

        return $writeOperation;
    }

    protected function formatValue(mixed $value): string
    {
        if (is_null($value)) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if ($this->isIpAddress($value) || $this->isUrl($value)) {
            return $value;
        }

        if ($this->isBase64String($value)) {
            return $value;
        }

        if ($this->isSimpleString($value)) {
            return $value;
        }

        $escapedValue = str_replace('"', '\"', $value);

        return '"'.$escapedValue.'"';
    }

    protected function isIpAddress(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    protected function isUrl(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    protected function isSimpleString(string $value): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9_-]+$/', $value);
    }

    protected function isBase64String(string $value): bool
    {
        return (bool) preg_match('/^base64:[A-Za-z0-9+\/=]+$/', $value);
    }

    protected function loadEnvContent()
    {
        $this->isEnvWritable();

        $this->envFileContents = file_get_contents($this->envFilePath());
    }
}
