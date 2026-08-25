<?php

declare(strict_types=1);

namespace Nova\Foundation;

class NovaBladeDirectives
{
    public static function icon(string $expression): string
    {
        return "<?php echo e(icon({$expression})); ?>";
    }

    public static function novaAdminScripts(string $expression): string
    {
        return '{!! \Nova\Foundation\Nova::adminScripts('.$expression.') !!}';
    }

    public static function novaAdminStyles(string $expression): string
    {
        return '{!! \Nova\Foundation\Nova::adminStyles('.$expression.') !!}';
    }

    public static function novaPublicScripts(string $expression): string
    {
        return '{!! \Nova\Foundation\Nova::publicScripts('.$expression.') !!}';
    }

    public static function novaPublicStyles(string $expression): string
    {
        return '{!! \Nova\Foundation\Nova::publicStyles('.$expression.') !!}';
    }

    public static function novaSetupScripts(string $expression): string
    {
        return '{!! \Nova\Foundation\Nova::setupScripts('.$expression.') !!}';
    }
}
