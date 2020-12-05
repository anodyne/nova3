<?php

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
        if ($iconSet = optional(optional(app('nova.settings'))->defaults)->iconSet) {
            return $this->sets[$iconSet];
        }

        return $this->sets['fluent'];
    }

    public function getSets(): array
    {
        return $this->sets;
    }
}
