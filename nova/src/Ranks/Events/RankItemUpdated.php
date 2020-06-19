<?php

namespace Nova\Ranks\Events;

use Nova\Ranks\Models\RankItem;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RankItemUpdated
{
    use Dispatchable;
    use SerializesModels;

    public $item;

    public function __construct(RankItem $item)
    {
        $this->item = $item;
    }
}
