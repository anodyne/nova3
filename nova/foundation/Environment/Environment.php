<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

readonly class Environment
{
    public function __construct(
        public Php $php,
        public Database $database,
        public PhpExtensions $extensions
    ) {}

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

    public static function make(): self
    {
        return new self(
            php: new Php,
            database: new Database,
            extensions: new PhpExtensions
        );
    }
}
