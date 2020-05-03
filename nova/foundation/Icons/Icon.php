<?php

namespace Nova\Foundation\Icons;

class Icon
{
    public function make($name, $class = '', array $attributes = [])
    {
        return svg($name, $class, $attributes);
    }
}
