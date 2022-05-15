<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Users\Models\User;

class UsersDropdown extends Component
{
    public $index;

    public $search;

    public $selected;

    public function selectUser($userId)
    {
        $this->dispatchBrowserEvent('users-dropdown-close');

        $this->selected = $this->filteredUsers->where('id', $userId)->first();

        $this->emitUp('userSelected', $userId, $this->index);

        $this->reset('search');
    }

    public function getFilteredUsersProperty(): Collection
    {
        return User::query()
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBy('name')
            ->get();
    }

    public function mount($user = null, $index = 0)
    {
        $this->index = $index;

        if ($user) {
            $this->selected = User::find($user);
        }
    }

    public function render()
    {
        return view('livewire.users.dropdown', [
            'filteredUsers' => $this->filteredUsers,
        ]);
    }
}
