<?php

use Nova\Foundation\Nova;
use Nova\Foundation\Toast;

if (! function_exists('toast')) {
    function toast()
    {
        return app(Toast::class);
    }
}

if (! function_exists('nova')) {
    function nova()
    {
        return app(Nova::class);
    }
}

if (! function_exists('nova_path')) {
    function nova_path($path = '')
    {
        return app()->novaPath($path);
    }
}

if (! function_exists('theme_path')) {
    function theme_path($path = '')
    {
        return app()->themePath($path);
    }
}