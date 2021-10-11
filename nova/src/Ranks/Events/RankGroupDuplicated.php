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

    public RankGroup $group;

    public RankGroup $original;

    public function __construct(RankGroup $group, RankGroup $original)
    {
        $this->group = $group;
        $this->original = $original;
    }
}
