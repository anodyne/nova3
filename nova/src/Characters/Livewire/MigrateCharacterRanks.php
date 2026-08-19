<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Setup\Models\Upgrade;

class MigrateCharacterRanks extends Component
{
    public Character $character;

    public ?int $rankId = null;

    public function updateRank(?int $rank): void
    {
        $this->rankId = $rank;

        $this->character->update(['rank_id' => $rank]);
    }

    public function getLegacyCharacter(): ?object
    {
        $legacyCharacterId = Upgrade::type('character')->where('new_id', $this->character->id)->first()?->old_id;

        return DB::connection('nova2')
            ->table('characters')
            ->join('ranks', 'characters.rank', '=', 'ranks.rank_id')
            ->where('charid', $legacyCharacterId)
            ->first();
    }

    public function getLegacyRank(): ?string
    {
        return $this->getLegacyCharacter()?->rank_name;
    }

    public function mount(): void
    {
        $this->rankId = $this->character->rank_id;
    }

    public function render(): Factory|View
    {
        return view('pages.characters.livewire.migrate-character-ranks', [
            'legacyRank' => $this->getLegacyRank(),
        ]);
    }
}
