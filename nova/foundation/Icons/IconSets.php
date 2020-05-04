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
}
