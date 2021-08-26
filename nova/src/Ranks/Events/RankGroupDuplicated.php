<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankGroup;

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
