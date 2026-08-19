<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Foundation\Actions\OptimizeOrRepairDatabase;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Models\ExternalContent;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use Nova\Menus\Actions\BustMenusCache;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Pages\Actions\BustPagesCache;
use Nova\Pages\Actions\RecachePages;
use Nova\Setup\Enums\NovaInstallStatus;
use Nova\Setup\Enums\SetupType;
use Throwable;

/**
 * @property-read bool $shouldShowForm
 * @property-read bool $shouldShowSuccessTable
 */
#[Layout('layouts.setup', ['type' => SetupType::Update])]
class UpdateNova extends Component
{
    public string $errorMessage = '';

    public ?NovaInstallStatus $status = null;

    public function update(): void
    {
        try {
            $this->runUpdater();

            $this->runCacheCommands();

            $this->syncExternalContentFromAnodyne();

            // (new Telemetry)->sendFullHeartbeat();

            $this->updateSystemInfo();

            $this->runDatabaseMaintenance();

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

    public function render(): Factory|View
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

        Artisan::call('migrate-data', [
            '--force' => true,
        ]);

        Artisan::call('optimize:clear');
        Artisan::call('package:discover');
        Artisan::call('filament:upgrade');

        Artisan::call('icons:cache');
        Artisan::call('view:cache');
        Artisan::call('storage:link');
    }

    protected function runCacheCommands(): void
    {
        Cache::forget(CacheKeys::UpdateAvailable->value);
        Cache::forget(CacheKeys::UpdateUpcoming->value);
        Cache::forget(CacheKeys::NextVersion->value);

        BustPagesCache::run();
        BustMenusCache::run();

        RecachePages::run();
        RecacheMenus::run();
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

    protected function runDatabaseMaintenance(): void
    {
        OptimizeOrRepairDatabase::run();
    }
}
