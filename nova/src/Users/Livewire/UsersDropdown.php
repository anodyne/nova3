<?php

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Models\User;

class UsersDropdown extends Component
{
    public $index;

    public $query;

    public $selected;

    public $users;

    public function selectUser($userId)
    {
        $this->dispatchBrowserEvent('users-dropdown-close');

        $this->selected = $this->users->where('id', $userId)->first();

        $this->emitUp('userSelected', $userId, $this->index);
    }

    public function updatedQuery($value)
    {
        $this->users = User::get();
    }

    public function mount($user = null, $index = 0)
    {
        $this->index = $index;
        $this->users = User::get();

        if ($user) {
            $this->selected = User::find($user);
        }
    }

    public function render()
    {
        return view('livewire.users.dropdown');
    }
}
