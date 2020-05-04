<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Svg;

class Icon
{
    protected $default = 'feather';

    public function make($name, $class = '', array $attributes = []): Svg
    {
        return svg(
            $this->getIconName($name),
            $this->buildClass($class),
            $attributes
        );
    }

    public function getIconSet(): IconSet
    {
        return app(IconSets::class)->get(cache()->get('nova.icon-set', $this->default));
    }

    protected function buildClass($class): string
    {
        $setClass = $this->getIconSet()->classes();

        return "${class} ${setClass}";
    }

    protected function getIconName($name): string
    {
        return sprintf(
            '%s-%s',
            cache()->get('nova.icon-set', $this->default),
            $this->getIconSet()->getIcon($name)
        );
    }
}
