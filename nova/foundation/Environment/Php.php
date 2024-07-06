<?php

declare(strict_types=1);

namespace Nova\Foundation\Environment;

class Php
{
    public function __construct(
        public readonly string $required = '8.2',
        public readonly string $version = PHP_VERSION
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
