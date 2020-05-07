<?php

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function icon($expression)
    {
        return "<?php echo e(icon(${expression})); ?>";
    }

    public static function novaScripts($expression)
    {
        return '{!! \Nova\Foundation\Nova::scripts(' . $expression . ') !!}';
    }
}
