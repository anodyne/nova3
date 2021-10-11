<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\ToggleDarkMode;

class DarkModeToggle extends Component
{
    public string $appearance = 'light';

    public function toggle()
    {
        $this->appearance = ToggleDarkMode::run();

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function mount()
    {
        $this->appearance = auth()->user()?->appearance ?? 'light';
    }

    public function render()
    {
        return view('livewire.users.dark-mode-toggle');
    }
}
