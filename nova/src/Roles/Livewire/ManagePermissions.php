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

    /** @var list<int> */
    public array $assigned = [];

    public function mount(): void
    {
        $this->assigned = $this->role?->permissions->pluck('id')->all() ?? [];
    }

    public function render(): Factory|View
    {
        return view('pages.roles.livewire.manage-permissions', [
            'permissions' => Permission::get(),
        ]);
    }
}
