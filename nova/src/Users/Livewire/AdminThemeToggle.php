<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\UpdateAdminTheme;

class AdminThemeToggle extends Component
{
    public $appearance;

    public function toggle($appearance = null)
    {
        $this->appearance = $appearance;

        UpdateAdminTheme::run($this->appearance);
    }

    public function mount()
    {
        $this->appearance = auth()->user()->appearance;
    }

    public function render()
    {
        return view('pages.users.livewire.admin-theme-toggle');
    }
}
