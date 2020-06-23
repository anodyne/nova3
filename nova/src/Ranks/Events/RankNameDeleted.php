<?php

namespace Nova\Ranks\Events;

use Nova\Ranks\Models\RankName;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RankNameDeleted
{
    use Dispatchable;
    use SerializesModels;

    public $name;

    public function __construct(RankName $name)
    {
        $this->name = $name;
    }
}
