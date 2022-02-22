<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Nova\Users\Models\User;

class UsersList extends Component
{
    use WithPagination;

    public $filters = [
        'status' => ['active'],
    ];

    public $search;

    public function getFilteredUsersProperty()
    {
        return User::query()
            ->when($this->filters['status'], fn ($query, $values) => $query->whereIn('status', $values))
            ->paginate();
    }

    public function render()
    {
        return view('livewire.users.users-list', [
            'users' => $this->filteredUsers,
        ]);
    }
}
