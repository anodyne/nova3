<?php

namespace Nova\Characters\Models\States\Statuses;

class Inactive extends CharacterStatus
{
    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
