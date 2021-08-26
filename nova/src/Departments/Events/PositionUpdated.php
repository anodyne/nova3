<?php

declare(strict_types=1);

namespace Nova\Departments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Departments\Models\Position;

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
