<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Enums\ReleaseSeverity;
use Nova\Foundation\Nova;
use Nova\Foundation\Values\LatestVersion;

class NovaUpdatePanelTrigger extends Component
{
    #[Computed]
    public function databaseVersion(): ?string
    {
        return Nova::databaseVersion();
    }

    #[Computed]
    public function filesVersion(): string
    {
        return Nova::filesVersion();
    }

    #[Computed]
    public function upstream(): LatestVersion
    {
        return Cache::get('nova-latest-version');
    }

    #[Computed]
    public function hasUpdate(): bool
    {
        return Cache::has('nova-update-available');
    }

    #[Computed]
    public function hasUpcomingUpdate(): bool
    {
        return Cache::has('nova-update-upcoming');
    }

    #[Computed]
    public function hasCriticalUpdate(): bool
    {
        return $this->hasUpdate && $this->upstream->severity === ReleaseSeverity::Critical;
    }

    #[Computed]
    public function needsFilesUpdate(): bool
    {
        return version_compare($this->filesVersion, $this->upstream->version, '<');
    }

    #[Computed]
    public function needsDatabaseUpdate(): bool
    {
        return version_compare($this->filesVersion, $this->databaseVersion, '>');
    }

    #[Computed]
    public function leadingText(): string
    {
        if (! $this->needsFilesUpdate) {
            return "Nova {$this->filesVersion}";
        }

        return "Nova {$this->upstream->version} is available";
    }

    #[Computed]
    public function trailingText(): string
    {
        if ($this->needsFilesUpdate) {
            return "Update from {$this->filesVersion}";
        }

        if ($this->needsDatabaseUpdate) {
            return "Your database needs to be updated from {$this->databaseVersion}";
        }

        return 'Your site is up-to-date';
    }

    public function render()
    {
        return view('pages.dashboards.livewire.nova-update-panel-trigger', [
            'databaseVersion' => $this->databaseVersion,
            'filesVersion' => $this->filesVersion,
            'upstream' => $this->upstream,
            'needsDatabaseUpdate' => $this->needsDatabaseUpdate,
            'needsFilesUpdate' => $this->needsFilesUpdate,
            'hasUpdate' => $this->hasUpdate,
            'hasCriticalUpdate' => $this->hasCriticalUpdate,
            'hasUpcomingUpdate' => $this->hasUpcomingUpdate,
            'leadingText' => $this->leadingText,
            'trailingText' => $this->trailingText,
        ]);
    }
}
