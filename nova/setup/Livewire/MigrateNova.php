<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Nova\Setup\Enums\NovaMigrateStatus;
use Nova\Users\Models\User;

class MigrateNova extends Component
{
    public ?NovaMigrateStatus $status = null;

    public function mount()
    {
        if (filled(config('database.connections.nova2.database'))) {
            $this->status = NovaMigrateStatus::DatabaseConfigured;
        }

        if (User::whereHas('roles', fn (Builder $query) => $query->whereIn('name', ['owner', 'admin']))->count() > 0) {
            $this->status = NovaMigrateStatus::UserAccessUpdated;
        }
    }

    public function render()
    {
        return view('setup.migrate-nova.index')
            ->layout('layouts.setup');
    }
}
