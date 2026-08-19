<?php

declare(strict_types=1);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (str_contains($_SERVER['REQUEST_URI'], 'public/')) {
    require_once __DIR__.'/messages/document-root.php';
    exit();
}

if (! is_dir('../vendor')) {
    if (! function_exists('exec')) {
        require_once __DIR__.'/messages/vendor-error.php.php';
        exit();
    }

    require_once __DIR__.'/messages/vendor-install.php';
    exit();
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../nova/bootstrap/app.php')
    ->handleRequest(Request::capture());
