<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;

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
| Defining it from the framework itself keeps analysis working without booting
| the whole application inside PHPStan.
|
*/

if (! defined('LARAVEL_VERSION')) {
    define('LARAVEL_VERSION', Application::VERSION);
}
