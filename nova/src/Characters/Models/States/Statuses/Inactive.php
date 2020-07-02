<?php

namespace Nova\Characters\Models\States\Statuses;

class Inactive extends CharacterStatus
{
    public function color(): string
    {
        return 'danger';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
