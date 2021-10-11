<?php

declare(strict_types=1);

namespace Nova\Characters\Models\States\Statuses;

class Pending extends CharacterStatus
{
    public function color(): string
    {
        return 'yellow';
    }

    public function name(): string
    {
        return 'pending';
    }
}
