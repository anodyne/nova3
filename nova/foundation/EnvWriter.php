<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Dotenv\Dotenv;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

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

    public function refreshEnvVars()
    {
        DotEnv::create(Env::getRepository(), App::environmentPath(), App::environmentFile())->load();
    }

    public function write(array $keys = []): bool
    {
        foreach ($keys as $key => $value) {
            if ($this->writeLine($key, $value) === false) {
                return false;
            }
        }

        return true;
    }

    public function writeLine(string $key, ?string $value): bool
    {
        $newValue = "{$key}={$value}";

        if ($this->lineExists($key)) {
            $replacedLine = str($this->envFileContents)->replaceMatches("/^$key=.*$/m", $newValue);

            File::put($this->envFilePath(), $replacedLine);
        } else {
            // If the last line isn't a new line, add one before the value
            if (! str($this->envFileContents)->isMatch("/\n$/")) {
                $newValue = "\n$newValue";
            }

            File::append($this->envFilePath(), $newValue);
        }

        $this->loadEnvContent();

        return true;
    }

    public function lineExists(string $key): bool
    {
        return str($this->envFileContents)->isMatch("/^$key=/m");
    }

    protected function loadEnvContent()
    {
        $this->envFileContents = File::get($this->envFilePath());
    }
}
