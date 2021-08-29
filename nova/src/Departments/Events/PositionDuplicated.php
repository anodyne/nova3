<?php

declare(strict_types=1);

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Position;

class PositionDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public Position $position;

    public Position $original;

    public function __construct(Position $position, Position $original)
    {
        $this->position = $position;
        $this->original = $original;
    }
}
