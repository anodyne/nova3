<?php

declare(strict_types=1);

namespace Nova\Setup\Controllers;

class StartSetupController
{
    public function __invoke()
    {
        return view('setup.overview.index');
    }
}
