<?php

namespace Nova\Departments\Events;

use Nova\Departments\Models\Position;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PositionUpdated
{
    use Dispatchable;
    use SerializesModels;

    public $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }
}
