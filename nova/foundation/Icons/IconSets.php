<?php

declare(strict_types=1);

namespace Nova\Foundation\Icons;

class IconSets
{
    protected ?IconSet $default;

    protected array $sets = [];

    public function add($alias, $class): self
    {
        $this->sets[$alias] = $class;

        return $this;
    }

    public function addDefault($alias, $class): self
    {
        $this->add($alias, $class);

        $this->default = $class;

        return $this;
    }

    public function get($alias): IconSet
    {
        return $this->sets[$alias];
    }

    public function getCurrentSet(): IconSet
    {
        return $this->get(settings()->appearance->iconSet) ?? $this->getDefault();
    }

    public function getDefault(): IconSet
    {
        return $this->default;
    }

    public function getSets(): array
    {
        return $this->sets;
    }
}
