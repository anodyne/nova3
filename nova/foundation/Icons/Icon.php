<?php

namespace Nova\Foundation\Icons;

use BladeUI\Icons\Svg;

class Icon
{
    protected $iconSet;

    public function __construct()
    {
        $this->iconSet = app(IconSets::class)->getDefaultSet();
    }

    public function make($name, $class = '', array $attributes = []): Svg
    {
        return svg(
            $this->getIconName($name),
            $class,
            $attributes
        );
    }

    protected function getIconName($name): string
    {
        return sprintf(
            '%s-%s',
            $this->iconSet->prefix(),
            $this->iconSet->getIcon($name)
        );
    }
}
