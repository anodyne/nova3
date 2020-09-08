<?php

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Models\User;
use Illuminate\Support\Collection;

class ManageUsers extends Component
{
    public $search;

    public $results;

    public $users = [];

    public function addUser($userId, $user)
    {
        $this->users[$userId] = $user;

        $this->dispatchBrowserEvent('dropdown-close');

        $this->reset(['search', 'results']);
    }

    public function removeUser($userId)
    {
        unset($this->users[$userId]);
    }

    public function updatedSearch($value)
    {
        $this->results = User::query()
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->orderBy('name')
            ->get();
    }

    public function mount($users)
    {
        $users = Collection::wrap($users);

        $this->users = $users
            ->mapWithKeys(fn ($user) => [$user->id => $user->toArray()])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.users.manage-users');
    }
}
