<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Characters\Actions\UpdateCharacter;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankItem;

class DeleteRankItemManager extends Action
{
    public function handle(RankItem $item): RankItem
    {
        return DB::transaction(function () use ($item) {
            $item->loadMissing('characters');

            $item->characters->each(function (Character $character): void {
                UpdateCharacter::run($character, CharacterData::from(
                    name: $character->name,
                    rank_id: null
                ));
            });

            return DeleteRankItem::run($item);
        });
    }
}
