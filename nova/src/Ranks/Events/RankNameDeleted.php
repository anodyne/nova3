<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankName;

class RankNameDeleted
{
    use Dispatchable;
    use SerializesModels;

    public RankName $name;

    public function __construct(RankName $name)
    {
        $this->name = $name;
    }
}
