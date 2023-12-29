<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class DiagnosticDataButton extends Component
{
    #[Computed]
    public function codeToCopy(): string
    {
        $env = app('nova.environment');

        $url = config('app.url');
        $theme = settings('appearance.theme');

        $novaVersion = app()->novaVersion();
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

        return <<<EOT
        ```
        URL: {$url}

        VERSIONS
        ====
        Nova version: {$novaVersion}
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
        ```
        EOT;
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" x-clipboard.raw="{{ $this->codeToCopy }}">Copy diagnostic data</x-button>
        blade;
    }
}
