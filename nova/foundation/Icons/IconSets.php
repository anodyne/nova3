<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class IconSets
{
    protected $sets = [];

    public function add($alias, $class): self
    {
        $this->sets[$alias] = $class;

        return $this;
    }

    public function get($alias): IconSet
    {
        return $this->sets[$alias];
    }

    public function getDefaultSet(): IconSet
    {
        $default = settings()?->appearance->iconSet ?? 'fluent';

        return $this->sets[$default];
    }

    public function getSets(): array
    {
        return $this->sets;
    }
}
