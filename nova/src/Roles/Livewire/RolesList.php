<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\CanReorder;
use Nova\Roles\Actions\ReorderRoles;
use Nova\Roles\Models\Role;

class RolesList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $defaultRoles = Filter::make('default_roles')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Assigned to new user(s)']);

        $hasPermissions = Filter::make('has_permissions')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Has assigned permissions']);

        $hasUsers = Filter::make('has_users')
            ->options(['yes' => 'Yes', 'no' => 'No'])
            ->meta(['label' => 'Has assigned users']);

        return [
            $defaultRoles,
            $hasPermissions,
            $hasUsers,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredRolesProperty()
    {
        $roles = Role::query()
            ->withCount([
                'user as active_users_count' => fn ($query) => $query->whereActive(),
                'user as inactive_users_count' => fn ($query) => $query->whereInactive(),
            ])
            ->with(['user' => fn ($query) => $query->whereActive()->limit(4)])
            ->when($this->getFilterValue('default_roles') === 'yes', fn ($query) => $query->where('default', true))
            ->when($this->getFilterValue('default_roles') === 'no', fn ($query) => $query->where('default', false))
            ->when($this->getFilterValue('has_permissions') === 'yes', fn ($query) => $query->whereHas('permissions'))
            ->when($this->getFilterValue('has_permissions') === 'no', fn ($query) => $query->whereDoesntHave('permissions'))
            ->when($this->getFilterValue('has_users') === 'yes', fn ($query) => $query->whereHas('user'))
            ->when($this->getFilterValue('has_users') === 'no', fn ($query) => $query->whereDoesntHave('user'))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $roles->get();
        }

        return $roles->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new Role());

        ReorderRoles::run($items);
    }

    public function render()
    {
        return view('livewire.roles.roles-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'roles' => $this->filteredRoles,
        ]);
    }
}
