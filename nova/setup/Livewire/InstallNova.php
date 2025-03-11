<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Addons\Actions\InstallAddon;
use Nova\Addons\Models\Addon;
use Nova\Foundation\EnvWriter;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Models\ExternalContent;
use Nova\Foundation\Nova;
use Nova\Menus\Actions\BustMenusCache;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Pages\Actions\BustPagesCache;
use Nova\Pages\Actions\RecachePages;
use Nova\Setup\Enums\NovaInstallStatus;
use Nova\Setup\Enums\SetupType;
use Nova\Themes\Actions\InstallTheme;
use Symfony\Component\Finder\Finder;
use Throwable;

#[Layout('layouts.setup', ['type' => SetupType::Install])]
class InstallNova extends Component
{
    public string $name = '';

    public ?string $genre = null;

    public bool $shouldSeed = false;

    public string $errorMessage = '';

    public ?NovaInstallStatus $status = null;

    public function install(): void
    {
        try {
            $this->runInstaller();

            $this->runCacheCommands();

            $this->setAppUrl();

            $this->installThemes();

            $this->installExtensions();

            $this->installGenreData();

            // $this->updateSettings();

            $this->seedDatabase();

            $this->syncExternalContentFromAnodyne();

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

    #[Computed]
    public function availableGenres(): array
    {
        $finder = new Finder;
        $finder->in(base_path('addons'))
            ->files()
            ->depth(1)
            ->contains('extends Genre');

        $disk = Storage::disk('addons');

        return collect($finder)
            ->flatMap(fn ($finder) => [$finder->getRelativePath()])
            ->reject(fn ($path) => ! $disk->exists("{$path}/addon.json"))
            ->flatMap(function ($path) use ($disk) {
                $data = json_decode($disk->get("{$path}/addon.json"), true);

                return [$path => data_get($data, 'name')];
            })
            ->toArray();
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
            'availableGenres' => $this->availableGenres,
            'shouldShowForm' => $this->shouldShowForm,
            'shouldShowSuccessTable' => $this->shouldShowSuccessTable,
        ]);
    }

    protected function runInstaller(): void
    {
        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);

        Artisan::call('operations:process');

        Artisan::call('optimize:clear');
        Artisan::call('package:discover');
        Artisan::call('filament:upgrade');

        Artisan::call('icons:cache');
        Artisan::call('view:cache');
        Artisan::call('storage:link');
    }

    protected function seedDatabase(): void
    {
        if ($this->shouldSeed) {
            Artisan::call('db:seed');
        }
    }

    protected function runCacheCommands(): void
    {
        BustPagesCache::run();
        BustMenusCache::run();

        RecachePages::run();
        RecacheMenus::run();
    }

    protected function installThemes(): void
    {
        $finder = new Finder;
        $finder->in(theme_path())
            ->directories()
            ->depth(0);

        collect($finder)
            ->flatMap(fn ($finder) => [$finder->getFilename()])
            ->reject(fn ($theme) => ! file_exists(theme_path($theme.'/theme.json')))
            ->each([InstallTheme::class, 'run']);
    }

    protected function installExtensions(): void
    {
        $finder = new Finder;
        $finder->in(addon_path())
            ->directories()
            ->depth(0);

        collect($finder)
            ->flatMap(fn ($finder) => [$finder->getFilename()])
            ->reject(fn ($addon) => ! file_exists(addon_path($addon.'/addon.json')))
            ->each([InstallAddon::class, 'run']);

        BustActiveAddonsCache::run();
    }

    protected function installGenreData(): void
    {
        if (filled($this->genre)) {
            $genre = Addon::location($this->genre)->first();

            $genre?->runScript('install');
        }
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
                $write = $envWriter->set('APP_URL', url('/'));

                if (! $write) {
                    throw new Exception('error writing to the ENV file');
                }
            }
        }
    }

    protected function syncExternalContentFromAnodyne(): void
    {
        ExternalChangelog::syncFromAnodyne();

        ExternalContent::syncFromAnodyne();
    }
}
