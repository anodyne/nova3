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

    public $name;

    public $originalName;

    public function __construct(RankName $name, RankName $originalName)
    {
        $this->name = $name;
        $this->originalName = $originalName;
    }
}
