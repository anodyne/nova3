<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Models\ExternalContent;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use Nova\Setup\Enums\NovaInstallStatus;
use Nova\Setup\Enums\SetupType;
use Nova\Setup\Telemetry;
use Throwable;

#[Layout('layouts.setup', ['type' => SetupType::Update])]
class UpdateNova extends Component
{
    public string $errorMessage = '';

    public ?NovaInstallStatus $status = null;

    public function update(): void
    {
        try {
            $this->runUpdater();

            $this->syncExternalContentFromAnodyne();

            // (new Telemetry)->sendFullHeartbeat();

            $this->updateSystemInfo();

            $this->status = NovaInstallStatus::Success;
        } catch (Throwable $th) {
            $this->errorMessage = $th->getMessage();

            $this->status = NovaInstallStatus::Failed;

            throw $th;
        }
    }

    #[Computed]
    public function shouldShowForm(): bool
    {
        return match ($this->status) {
            NovaInstallStatus::AlreadyInstalled => false,
            NovaInstallStatus::Success => false,
            default => true,
        };
    }

    #[Computed]
    public function shouldShowSuccessTable(): bool
    {
        return match ($this->status) {
            NovaInstallStatus::AlreadyInstalled => true,
            NovaInstallStatus::Success => true,
            default => false,
        };
    }

    public function render()
    {
        return view('setup.update-nova.index', [
            'shouldShowForm' => $this->shouldShowForm,
            'shouldShowSuccessTable' => $this->shouldShowSuccessTable,
        ]);
    }

    protected function runUpdater(): void
    {
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        Artisan::call('operations:process');

        Artisan::call('optimize:clear');
        Artisan::call('package:discover');
        Artisan::call('filament:upgrade');

        Artisan::call('icons:cache');
        Artisan::call('view:cache');
        Artisan::call('storage:link');

        Cache::forget('nova-update-available');
    }

    protected function syncExternalContentFromAnodyne(): void
    {
        ExternalChangelog::syncFromAnodyne();

        ExternalContent::syncFromAnodyne();
    }

    protected function updateSystemInfo(): void
    {
        SystemInfo::first()->update([
            'version' => Nova::filesVersion(),
            'last_update' => Date::now(),
        ]);
    }
}
