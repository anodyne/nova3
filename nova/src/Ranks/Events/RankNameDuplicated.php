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

    public function __construct(
        public RankName $name,
        public RankName $original
    ) {}
}
