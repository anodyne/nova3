<?php

declare(strict_types=1);

namespace Nova\Setup\Controllers;

use Nova\Foundation\Nova;

class UpdateWhatsNewController
{
    public function __invoke()
    {
        return view('setup.update-nova.whats-new', [
            'versionComingFrom' => Nova::databaseVersion(),
            'versionGoingTo' => Nova::filesVersion(),
        ]);
    }
}
