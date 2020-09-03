<?php

namespace Nova\Users\Models\States;

class Pending extends UserStatus
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
