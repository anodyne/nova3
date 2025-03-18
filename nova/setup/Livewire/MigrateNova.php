<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Setup\Enums\NovaMigrateStatus;
use Nova\Setup\Enums\SetupType;

#[Layout('layouts.setup', ['type' => SetupType::Migrate])]
class MigrateNova extends Component
{
    public ?NovaMigrateStatus $status = null;

    public function mount()
    {
        if (filled(config('database.connections.nova2.database'))) {
            $this->status = NovaMigrateStatus::DatabaseConfigured;
        }

        if (Cache::has('migration_complete')) {
            $this->status = NovaMigrateStatus::DataMigrated;
        }

        if (Cache::has('migration_account_setup_complete')) {
            $this->status = NovaMigrateStatus::Success;
        }

        if ($this->status === NovaMigrateStatus::Success) {
            $this->dispatch('confetti');
        }
    }

    public function render()
    {
        return view('setup.migrate-nova.index');
    }
}
