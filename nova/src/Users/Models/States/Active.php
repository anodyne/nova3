<?php

namespace Nova\Users\Models\States;

class Active extends UserStatus
{
    public function color(): string
    {
        return 'green';
    }

    public function name(): string
    {
        return 'active';
    }
}
