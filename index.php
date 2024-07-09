<?php

declare(strict_types=1);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (version_compare(PHP_VERSION, '8.2', '<')) {
    header('Location: message.php?type=php');
    exit();
}

if (! is_dir('vendor')) {
    if (! function_exists('exec')) {
        header('Location: message.php?type=vendor-error');
        exit();
    }

    header('Location: message.php?type=vendor-install');
    exit();
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/nova/bootstrap/app.php')
    ->handleRequest(Request::capture());
