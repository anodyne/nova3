<?php

declare(strict_types=1);

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function icon($expression)
    {
        return "<?php echo e(icon({$expression})); ?>";
    }

    public static function novaScripts($expression)
    {
        return '{!! \Nova\Foundation\Nova::scripts(' . $expression . ') !!}';
    }

    public static function novaStyles($expression)
    {
        return '{!! \Nova\Foundation\Nova::styles(' . $expression . ') !!}';
    }
}
