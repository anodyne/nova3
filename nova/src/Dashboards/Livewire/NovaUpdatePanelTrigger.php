<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Foundation\Enums\ReleaseSeverity;
use Nova\Foundation\Nova;
use Nova\Foundation\Values\LatestVersion;

/**
 * @property-read ?string $databaseVersion
 * @property-read string $filesVersion
 * @property-read LatestVersion $upstream
 * @property-read bool $hasUpdate
 * @property-read bool $hasUpcomingUpdate
 * @property-read bool $hasCriticalUpdate
 * @property-read bool $needsFilesUpdate
 * @property-read bool $needsDatabaseUpdate
 * @property-read string $leadingText
 * @property-read ?string $trailingText
 */
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
        return Cache::get(CacheKeys::LatestVersion->value);
    }

    #[Computed]
    public function hasUpdate(): bool
    {
        return Cache::has(CacheKeys::UpdateAvailable->value);
    }

    #[Computed]
    public function hasUpcomingUpdate(): bool
    {
        return Cache::has(CacheKeys::UpdateUpcoming->value);
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
    public function trailingText(): ?string
    {
        if ($this->needsFilesUpdate) {
            return "Update from {$this->filesVersion}";
        }

        if ($this->needsDatabaseUpdate) {
            return "Update your database from {$this->databaseVersion}";
        }

        return null;
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
