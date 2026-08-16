<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Nova\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Larastan Bootstrap Shim
|--------------------------------------------------------------------------
|
| Larastan's own bootstrap only looks for `bootstrap/app.php` relative to the
| working directory. Nova keeps its application bootstrap at
| `nova/bootstrap/app.php`, so Larastan never resolves the application and
| never defines `LARAVEL_VERSION`. Since Larastan 3.10 its stub file extension
| reads that constant unconditionally, which aborts the analysis.
|
| Load Nova's application and bootstrap its console kernel so Laravel helpers
| resolve against the application container during analysis.
|
*/

/** @var Application $app */
$app = require __DIR__.'/nova/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

if (! defined('LARAVEL_VERSION')) {
    define('LARAVEL_VERSION', Application::VERSION);
}
