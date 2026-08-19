<?php

declare(strict_types=1);

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function icon($expression): string
    {
        return "<?php echo e(icon({$expression})); ?>";
    }

    public static function novaAdminScripts($expression): string
    {
        return '{!! \Nova\Foundation\Nova::adminScripts('.$expression.') !!}';
    }

    public static function novaAdminStyles($expression): string
    {
        return '{!! \Nova\Foundation\Nova::adminStyles('.$expression.') !!}';
    }

    public static function novaPublicScripts($expression): string
    {
        return '{!! \Nova\Foundation\Nova::publicScripts('.$expression.') !!}';
    }

    public static function novaPublicStyles($expression): string
    {
        return '{!! \Nova\Foundation\Nova::publicStyles('.$expression.') !!}';
    }

    public static function novaSetupScripts($expression): string
    {
        return '{!! \Nova\Foundation\Nova::setupScripts('.$expression.') !!}';
    }
}
