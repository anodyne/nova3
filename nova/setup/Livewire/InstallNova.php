<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Foundation\EnvWriter;
use Nova\Foundation\Nova;
use Nova\Setup\Enums\NovaInstallStatus;
use Symfony\Component\Finder\Finder;
use Throwable;

class InstallNova extends Component
{
    public string $name = '';

    public string $genre = 'st24';

    public bool $shouldSeed = false;

    public string $errorMessage = '';

    public ?NovaInstallStatus $status = null;

    public function install(): void
    {
        try {
            $this->runInstaller();

            $this->setAppUrl();

            // $this->installThemes();

            // $this->installExtensions();

            // $this->updateSettings();

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

    public function mount()
    {
        if (app()->environment('local')) {
            $this->shouldSeed = true;
        }

        if (Nova::isInstalled()) {
            $this->status = NovaInstallStatus::AlreadyInstalled;
        }
    }

    public function render()
    {
        return view('setup.install-nova.index', [
            'shouldShowForm' => $this->shouldShowForm,
            'shouldShowSuccessTable' => $this->shouldShowSuccessTable,
        ])->layout('layouts.setup');
    }

    protected function runInstaller(): void
    {
        Artisan::call('migrate:fresh', [
            '--seed' => $this->shouldSeed,
            '--force' => true,
        ]);

        Artisan::call('optimize:clear');
        Artisan::call('package:discover');
        Artisan::call('filament:upgrade');

        Artisan::call('icons:cache');
        Artisan::call('view:cache');
    }

    protected function installThemes(): void {}

    protected function installExtensions(): void
    {
        $finder = Finder::create()
            ->in(addon_path())
            ->directories()
            ->depth(0);

        $addons = collect($finder)
            ->flatMap(fn ($finder) => [$finder->getFilename()])
            ->reject(fn ($addon) => ! file_exists(addon_path($addon.'/addon.json')))
            ->flatMap(fn ($addon) => ["Addons\\$addon\\Addon"])
            ->each(fn ($addon) => (new $addon)->install());

        BustActiveAddonsCache::run();

        // Get all of the add-ons in the add-ons directory
        // Make sure we only have add-ons with a QuickInstall file
        // Install the add-on into the database
        // Run any installer the add-on has
        // Cache everything
    }

    protected function updateSettings(): void
    {
        settings()->update([
            'game_name' => $this->name,
        ]);
    }

    protected function setAppUrl(): void
    {
        $envWriter = app(EnvWriter::class);

        if ($envWriter->isEnvWritable()) {
            $path = $envWriter->envFilePath();

            if (file_exists($path)) {
                $write = $envWriter->write([
                    'APP_URL' => url('/'),
                ]);

                if (! $write) {
                    throw new Exception('error writing to the ENV file');
                }
            }
        }
    }
}
