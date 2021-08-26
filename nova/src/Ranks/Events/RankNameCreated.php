<?php

declare(strict_types=1);

namespace Nova\Ranks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Ranks\Models\RankName;

class RankNameCreated
{
    use Dispatchable;
    use SerializesModels;

    public $name;

    public function __construct(RankName $name)
    {
        $this->name = $name;
    }
}
