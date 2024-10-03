<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

use Illuminate\View\Component;

class AuthLayout extends Component
{
    public function __construct(
        public string $pageHeader
    ) {}

    public function render()
    {
        return view('layouts.auth');
    }
}
