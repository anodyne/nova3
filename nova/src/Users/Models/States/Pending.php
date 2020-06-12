<?php

namespace Nova\Users\Models\States;

class Pending extends UserStatus
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
