<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankGroup;

class RankGroupCreated
{
    use Dispatchable;
    use SerializesModels;

    public $group;

    public function __construct(RankGroup $group)
    {
        $this->group = $group;
    }
}
