<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class DeleteRankName
{
    use AsAction;

    public function handle(RankName $name): RankName
    {
        $name->ranks->each(fn (RankItem $item) => DeleteRankItem::run($item));

        return tap($name)->delete();
    }
}
