<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

abstract class IconSet
{
    abstract public function icons(): array;

    abstract public function name(): string;

    abstract public function prefix(): string;

    public function additionalClasses(): ?string
    {
        return null;
    }

    public function getIcon(string $alias): string
    {
        return data_get($this->map(), $alias, $alias);
    }

    final public function map(): array
    {
        return array_merge(
            app(IconSets::class)->getDefault()->icons(),
            $this->icons()
        );
    }
}
