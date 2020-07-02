<?php

namespace Nova\Characters\Models\States\Statuses;

class Pending extends CharacterStatus
{
    public function color(): string
    {
        return 'warning';
    }

    public function name(): string
    {
        return 'pending';
    }
}
