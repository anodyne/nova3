<?php

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Models\User;

class UsersDropdown extends Component
{
    public $index;

    public $search;

    public $selected;

    public $users;

    public function selectUser($userId)
    {
        $this->dispatchBrowserEvent('users-dropdown-close');

        $this->selected = $this->users->where('id', $userId)->first();

        $this->emitUp('userSelected', $userId, $this->index);

        $this->resetUsers();
    }

    public function updatedSearch($value)
    {
        $this->users = User::query()
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->orderBy('name')
            ->get();
    }

    public function mount($user = null, $index = 0)
    {
        $this->index = $index;
        $this->resetUsers();

        if ($user) {
            $this->selected = User::find($user);
        }
    }

    public function render()
    {
        return view('livewire.users.dropdown');
    }

    protected function resetUsers()
    {
        $this->reset('search');
        $this->users = User::get();
    }
}
