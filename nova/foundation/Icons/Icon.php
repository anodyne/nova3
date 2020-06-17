<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Svg;

class Icon
{
    protected $default = 'fluent';

    public function make($name, $class = '', array $attributes = []): Svg
    {
        dump($name, $class, $attributes, $this->getIconName($name));

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
        dump($this->getIconSet(), $this->getIconSet()->getIcon($name));

        return sprintf(
            '%s-%s',
            $this->default,
            $this->getIconSet()->getIcon($name)
        );
    }
}
