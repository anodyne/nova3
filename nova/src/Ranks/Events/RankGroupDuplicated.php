<?php

namespace Nova\Ranks\Events;

use Nova\Ranks\Models\RankGroup;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RankGroupDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $group;

    public $originalGroup;

    public function __construct(RankGroup $group, RankGroup $originalGroup)
    {
        $this->group = $group;
        $this->originalGroup = $originalGroup;
    }
}
