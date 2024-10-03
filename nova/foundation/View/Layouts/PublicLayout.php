<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

use Illuminate\View\Component;
use Nova\Pages\Models\Page;

class PublicLayout extends Component
{
    protected ?Page $page;

    public function __construct()
    {
        $this->page = request()->route()?->findPageFromRoute();
    }

    public function render()
    {
        return view('layouts.public');
    }
}
