<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\UpdateCharacter;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Ranks\Models\RankItem;

class DeleteRankItem
{
    use AsAction;

    public function handle(RankItem $item): RankItem
    {
        $item->characters->each(function (Character $character) {
            UpdateCharacter::run(new CharacterData(
                name: $character->name,
                rank_id: null
            ));
        });

        return tap($item)->delete();
    }
}
