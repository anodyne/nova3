<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Nova;

class VersionChecker extends Component
{
    public bool $sidebarOpen = false;

    #[Computed]
    public function databaseVersion()
    {
        return Nova::getVersion();
    }

    #[Computed]
    public function filesVersion()
    {
        return Nova::getVersion();
    }

    #[Computed]
    public function upstream()
    {
        return Cache::get('nova-latest-version');
    }

    #[Computed]
    public function hasUpdate(): bool
    {
        return Cache::has('nova-update-available');
    }

    #[Computed]
    public function hasCriticalUpdate(): bool
    {
        return $this->hasUpdate && $this->upstream['severity'] === 'critical';
    }

    public function mount()
    {
        $this->sidebarOpen = true;
    }

    public function render()
    {
        return view('pages.dashboards.livewire.version-checker', [
            'databaseVersion' => $this->databaseVersion,
            'filesVersion' => $this->filesVersion,
            'upstream' => $this->upstream,
        ]);
    }
}
