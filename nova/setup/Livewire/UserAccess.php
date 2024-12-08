<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Roles\Models\Role;
use Nova\Setup\Enums\SetupType;

#[Layout('layouts.setup', ['type' => SetupType::Install])]
class UserAccess extends Component
{
    #[Computed]
    public function roles(): Collection
    {
        return Role::query()
            ->with('user')
            ->withCount('user')
            ->ordered()
            ->get();
    }

    public function render()
    {
        return view('setup.migrate-nova.user-access', [
            'roles' => $this->roles,
        ]);
    }
}
