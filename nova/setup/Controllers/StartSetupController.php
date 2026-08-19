<?php

declare(strict_types=1);

namespace Nova\Setup\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Nova\Foundation\Nova;

class StartSetupController implements HasMiddleware
{
    public function __invoke(): Factory|View
    {
        return view('setup.overview.index');
    }

    public static function middleware()
    {
        if (Nova::isInstalled()) {
            return ['auth', 'permission:site.update'];
        }

        return [];
    }
}
