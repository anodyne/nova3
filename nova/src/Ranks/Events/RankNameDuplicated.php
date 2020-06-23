<?php

namespace Nova\Ranks\Events;

use Nova\Ranks\Models\RankName;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RankNameDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $name;

    public $originalName;

    public function __construct(RankName $name, RankName $originalName)
    {
        $this->name = $name;
        $this->originalName = $originalName;
    }
}
