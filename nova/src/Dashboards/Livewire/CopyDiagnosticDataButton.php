<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Nova;

class CopyDiagnosticDataButton extends Component
{
    #[Computed]
    public function codeToCopy(): string
    {
        $env = app('nova.environment');

        $url = config('app.url');
        $theme = settings('appearance.theme');

        $novaFilesVersion = Nova::filesVersion();
        $novaDatabaseVersion = Nova::databaseVersion();
        $phpVersion = PHP_VERSION;
        $database = "{$env->database->driverName()} {$env->database->version}";
        $laravelVersion = app()->version();
        $livewireVersion = app()->livewireVersion();
        $filamentVersion = app()->filamentVersion();

        $debugMode = config('app.debug') ? 'Enabled' : 'Off';
        $environment = config('app.env');

        $mailDriver = config('mail.default');
        $loggingDriver = config('logging.default');
        $cacheDriver = config('cache.default');
        $sessionDriver = config('session.driver');
        $queueDriver = config('queue.default');
        $broadcastingDriver = config('broadcasting.default');

        $activeExtensions = collect(data_get(Cache::get(CacheKeys::Addons->value), 'extension', []))->join(', ') ?: 'None';
        $activeGenre = collect(data_get(Cache::get(CacheKeys::Addons->value), 'genre', []))->join(', ') ?: 'None';
        $activeRankSet = collect(data_get(Cache::get(CacheKeys::Addons->value), 'rank', []))->join(', ') ?: 'None';

        return <<<EOT
        ```
        URL: {$url}

        VERSIONS
        ====
        Nova version (files): {$novaFilesVersion}
        Nova version (database): {$novaDatabaseVersion}
        Laravel version: {$laravelVersion}
        Livewire version: {$livewireVersion}
        Filament version: {$filamentVersion}

        ENVIRONMENT
        ====
        PHP: PHP {$phpVersion}
        Database: {$database}
        Debug mode: {$debugMode}
        Environment: {$environment}
        Public theme: {$theme}

        DRIVERS
        ====
        Mail: {$mailDriver}
        Logging: {$loggingDriver}
        Cache: {$cacheDriver}
        Session: {$sessionDriver}
        Queue: {$queueDriver}
        Broadcasting: {$broadcastingDriver}

        ADD-ONS
        ====
        Extensions: {$activeExtensions}
        Genre: {$activeGenre}
        Rank set: {$activeRankSet}
        ```
        EOT;
    }

    public function render()
    {
        return <<<'blade'
            <div
                class="flex items-center gap-x-2"
                x-data="{ copied: false }"
                x-init="$watch('copied', () => setTimeout(() => copied = false, 2000))"
            >
                <x-button
                    type="button"
                    x-clipboard.raw="{{ $this->codeToCopy }}"
                    x-on:click="copied = true"
                >
                    Copy diagnostic data
                    <x-icon :name="Tabler::Copy" size="sm" x-show="!copied" />
                    <x-icon :name="Tabler::CopyCheck" size="sm" class="text-primary-500" x-show="copied" x-cloak />
                </x-button>
            </div>
        blade;
    }
}
