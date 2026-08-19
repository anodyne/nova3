<?php

declare(strict_types=1);

namespace Nova\Setup\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Nova\Foundation\Nova;

class UpdateWhatsNewController
{
    public function __invoke(): Factory|View
    {
        return view('setup.update-nova.whats-new', [
            'versionComingFrom' => Nova::databaseVersion(),
            'versionGoingTo' => Nova::filesVersion(),
        ]);
    }
}
