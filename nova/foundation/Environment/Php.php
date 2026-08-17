<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

readonly class Php
{
    public function __construct(
        public string $required = '8.4',
        public string $version = PHP_VERSION
    ) {}

    public function fails(): bool
    {
        return ! $this->passes();
    }

    public function passes(): bool
    {
        return version_compare($this->version, $this->required, '>');
    }
}
