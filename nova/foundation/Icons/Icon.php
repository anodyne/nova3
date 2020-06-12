<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Svg;

class Icon
{
    protected $default = 'fluent';

    public function make($name, $class = '', array $attributes = []): Svg
    {
        return svg(
            $this->getIconName($name),
            $class,
            $attributes
        );
    }

    public function getIconSet(): IconSet
    {
        return app(IconSets::class)->get(cache()->get('nova.icon-set', $this->default));
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
