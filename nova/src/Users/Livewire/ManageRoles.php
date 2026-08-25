<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageRoles extends Component
{
    #[Locked]
    public ?User $user = null;

    /** @var list<int> */
    public array $assigned = [];

    public function mount(): void
    {
        $this->assigned = array_values($this->user?->roles
            ->map(fn (Role $role): int => $role->id)
            ->values()
            ->all() ?? []);
    }

    public function render(): Factory|View
    {
        return view('pages.users.livewire.manage-roles', [
            'roles' => Role::get(),
        ]);
    }
}
