<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\ToggleDarkMode;

class DarkModeToggle extends Component
{
    public bool $on = false;

    public function toggle()
    {
        ToggleDarkMode::run();

        $this->on = ! $this->on;

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function mount()
    {
        $this->on = ! ! auth()->user()?->dark_mode;
    }

    public function render()
    {
        return view('livewire.users.dark-mode-toggle');
    }
}
