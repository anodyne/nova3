<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Setup\Enums\NovaMigrateStatus;
use Nova\Setup\Enums\SetupType;

#[Layout('layouts.setup', ['type' => SetupType::Migrate])]
class MigrateNova extends Component
{
    public ?NovaMigrateStatus $status = null;

    public ?string $legacyVersion = null;

    public function mount()
    {
        if (filled(config('database.connections.nova2.database'))) {
            $this->status = NovaMigrateStatus::DatabaseConfigured;
        }

        if ($this->status === NovaMigrateStatus::DatabaseConfigured) {
            $this->getLegacyNovaVersion();
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

    protected function getLegacyNovaVersion(): void
    {
        $systemInfo = DB::connection('nova2')->table('system_info')->first();

        $this->legacyVersion = collect([
            $systemInfo->sys_version_major,
            $systemInfo->sys_version_minor,
            $systemInfo->sys_version_update,
        ])->join('.');

        if (version_compare($this->legacyVersion, '2.7.13', '<')) {
            $this->status = NovaMigrateStatus::InsufficientLegacyVersion;
        }
    }
}
