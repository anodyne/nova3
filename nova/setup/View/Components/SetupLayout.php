<?php

declare(strict_types=1);

namespace Nova\Setup\View\Components;

use Illuminate\View\Component;

class SetupLayout extends Component
{
    public function render()
    {
        return view('layouts.setup');
    }
}
