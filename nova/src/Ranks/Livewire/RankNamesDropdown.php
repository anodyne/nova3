<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Models\RankName;

class RankNamesDropdown extends Component
{
    public ?int $name = null;

    #[Computed]
    public function rankNames(): Collection
    {
        return RankName::query()
            ->ordered()
            ->get();
    }

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-names-dropdown', [
            'rankNames' => $this->rankNames,
        ]);
    }
}
