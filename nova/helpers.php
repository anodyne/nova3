<?php

use Nova\Foundation\Nova;
use Nova\Foundation\Alert;

if (! function_exists('alert')) {
    function alert()
    {
        return app(Alert::class);
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