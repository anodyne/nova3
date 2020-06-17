<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Factory;

class IconSets
{
    protected $sets = [];

    public function add($alias, $class): self
    {
        $this->sets[$alias] = $class;

        app(Factory::class)->add($alias, config('blade-icons.sets')[$alias]);

        return $this;
    }

    public function get($alias): IconSet
    {
        return $this->sets[$alias];
    }

    public function getSets(): array
    {
        return $this->sets;
    }
}
