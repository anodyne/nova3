<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Nova;

/**
 * @property-read string $filesVersion
 * @property-read ?string $databaseVersion
 * @property-read Collection $versionHistory
 */
class NovaVersionHistory extends Component
{
    public ?string $start = null;

    public ?string $end = null;

    #[Computed]
    public function filesVersion(): string
    {
        return Nova::filesVersion();
    }

    #[Computed]
    public function databaseVersion(): ?string
    {
        return Nova::databaseVersion();
    }

    #[Computed]
    public function versionHistory(): Collection
    {
        return ExternalChangelog::query()
            ->when(filled($this->start), fn (Builder $query): Builder => $query->where('version', '>=', $this->start))
            ->when(filled($this->end), fn (Builder $query): Builder => $query->where('version', '<=', $this->end))
            ->orderBy('series', 'desc')
            ->orderBy('version', 'desc')
            ->get();
    }

    public function render()
    {
        return view('pages.dashboards.livewire.nova-version-history', [
            'databaseVersion' => $this->databaseVersion,
            'filesVersion' => $this->filesVersion,
            'versionHistory' => $this->versionHistory,
        ]);
    }
}
