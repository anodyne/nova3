<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

class Environment
{
    public readonly Php $php;

    public readonly PhpExtensions $extensions;

    public readonly Database $database;

    public function fails(): bool
    {
        return $this->php->fails() ||
            $this->extensions->fails() ||
            $this->database->fails();
    }

    public function passes(): bool
    {
        return $this->php->passes() &&
            $this->extensions->passes() &&
            $this->database->passes();
    }

    public static function make(): static
    {
        $environment = new static();
        $environment->php = new Php();
        $environment->extensions = new PhpExtensions();
        $environment->database = new Database();

        return $environment;
    }
}
