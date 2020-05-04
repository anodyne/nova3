<?php

namespace Nova\Foundation\Icons;

use Nova\Foundation\Exceptions\IconNotFound;

abstract class IconSet
{
    abstract public function classes(): string;

    abstract public function map(): array;

    abstract public function name(): string;

    abstract public function prefix(): string;

    public function getIcon(string $alias): string
    {
        if (! array_key_exists($alias, $this->map())) {
            throw IconNotFound::missing($this->name(), $alias);
        }

        return data_get($this->map(), $alias);
    }
}
