<?php

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function novaScripts($expression)
    {
        return '{!! \Nova\Foundation\Nova::scripts(' . $expression . ') !!}';
    }
}
