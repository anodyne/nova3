<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Svg;
use BladeUI\Icons\Factory;

class Icon
{
    protected $default = 'fluent';

    public function make($name, $class = '', array $attributes = []): Svg
    {
        dump(app(Factory::class)->all());

        return svg(
            $this->getIconName($name),
            $class,
            $attributes
        );
    }

    public function getIconSet(): IconSet
    {
        return app(IconSets::class)->get($this->default);
    }

    protected function getIconName($name): string
    {
        return sprintf(
            '%s-%s',
            $this->default,
            $this->getIconSet()->getIcon($name)
        );
    }
}
