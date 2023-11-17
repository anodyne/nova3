<?php

declare(strict_types=1);

namespace Nova\Posts\View\Components;

use Illuminate\View\Component;

class WritePostWizardLayout extends Component
{
    public function __construct(
        public $steps,
        public string $message
    ) {
    }

    public function render()
    {
        return view('components.layouts.write-post-wizard');
    }
}
