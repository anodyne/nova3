<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Nova\Users\Actions\UpdateAdminTheme;

class AdminThemeToggle extends Component
{
    public string $appearance = '';

    public function updatedAppearance(): void
    {
        $this->dispatch('dropdown-close');

        UpdateAdminTheme::run($this->appearance);
    }

    public function mount()
    {
        $this->appearance = Auth::user()->appearance;
    }

    public function render()
    {
        return view('pages.users.livewire.admin-theme-toggle');
    }
}
