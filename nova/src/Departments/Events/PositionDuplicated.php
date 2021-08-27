<?php

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Position;

class PositionDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $position;

    public $original;

    public function __construct(Position $position, Position $original)
    {
        $this->position = $position;
        $this->original = $original;
    }
}
