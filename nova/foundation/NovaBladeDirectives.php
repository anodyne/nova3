<?php

declare(strict_types=1);

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function icon($expression)
    {
        return "<?php echo e(icon({$expression})); ?>";
    }

    public static function novaAdminScripts($expression)
    {
        return '{!! \Nova\Foundation\Nova::adminScripts('.$expression.') !!}';
    }

    public static function novaAdminStyles($expression)
    {
        return '{!! \Nova\Foundation\Nova::adminStyles('.$expression.') !!}';
    }

    public static function novaPublicScripts($expression)
    {
        return '{!! \Nova\Foundation\Nova::publicScripts('.$expression.') !!}';
    }

    public static function novaPublicStyles($expression)
    {
        return '{!! \Nova\Foundation\Nova::publicStyles('.$expression.') !!}';
    }
}
