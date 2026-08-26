<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;

class ManagePermissions extends Component
{
    #[Locked]
    public ?Role $role = null;

    /** @var list<string> */
    public array $assigned = [];

    public function mount(): void
    {
        $this->assigned = array_values($this->role?->permissions
            ->map(fn (Permission $permission): string => $permission->id)
            ->values()
            ->all() ?? []);
    }

    public function render(): Factory|View
    {
        return view('pages.roles.livewire.manage-permissions', [
            'permissions' => Permission::get(),
        ]);
    }
}
