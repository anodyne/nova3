<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\EnvWriter;
use Nova\Foundation\Nova;
use Nova\Setup\Enums\NovaInstallStatus;
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

            // $this->updateSettings();

            $this->status = NovaInstallStatus::success;
        } catch (Throwable $th) {
            $this->errorMessage = $th->getMessage();

            $this->status = NovaInstallStatus::failed;

            throw $th;
        }
    }

    #[Computed]
    public function shouldShowForm(): bool
    {
        return match ($this->status) {
            NovaInstallStatus::alreadyInstalled => false,
            NovaInstallStatus::success => false,
            default => true,
        };
    }

    #[Computed]
    public function shouldShowSuccessTable(): bool
    {
        return match ($this->status) {
            NovaInstallStatus::alreadyInstalled => true,
            NovaInstallStatus::success => true,
            default => false,
        };
    }

    public function mount()
    {
        if (app()->environment('local')) {
            $this->shouldSeed = true;
        }

        if (Nova::isInstalled()) {
            $this->status = NovaInstallStatus::alreadyInstalled;
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
