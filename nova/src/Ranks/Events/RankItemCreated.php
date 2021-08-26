<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankItem;

class RankItemCreated
{
    use Dispatchable;
    use SerializesModels;

    public $item;

    public function __construct(RankItem $item)
    {
        $this->item = $item;
    }
}
