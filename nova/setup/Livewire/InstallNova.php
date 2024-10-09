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
