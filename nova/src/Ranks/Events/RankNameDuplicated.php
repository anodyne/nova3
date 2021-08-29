<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankName;

class RankNameDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public RankName $name;

    public RankName $original;

    public function __construct(RankName $name, RankName $original)
    {
        $this->name = $name;
        $this->original = $original;
    }
}
