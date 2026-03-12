<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Users\Models\User;

class ManageRoles extends Component
{
    #[Locked]
    public ?User $user = null;

    public array $assigned = [];

    public function mount(): void
    {
        $this->assigned = $this->user?->roles->pluck('id')->all() ?? [];
    }

    public function render()
    {
        return view('pages.users.livewire.manage-roles', [
            'roles' => Role::get(),
        ]);
    }
}
