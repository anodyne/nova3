<?php

namespace Nova\Ranks\Events;

use Nova\Ranks\Models\RankGroup;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

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
