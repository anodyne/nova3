<?php

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Models\User;
use Illuminate\Support\Collection;

class ManageUsers extends Component
{
    public $users = [];

    public $query;

    public $results;

    public function addUser($userId, $user)
    {
        $this->users[$userId] = $user;

        $this->dispatchBrowserEvent('dropdown-close');

        $this->query = null;
        $this->results = null;
    }

    public function removeUser($userId)
    {
        unset($this->users[$userId]);
    }

    public function updatedQuery($value)
    {
        $this->results = User::query()
            ->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orderBy('name')
            ->get();
    }

    public function mount($users)
    {
        Collection::wrap($users)
            ->each(function ($user) {
                $this->users[$user->id] = $user->toArray();
            });
    }

    public function render()
    {
        return view('livewire.users.manage-users');
    }
}
