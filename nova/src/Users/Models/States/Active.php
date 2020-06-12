<?php

namespace Nova\Users\Models\States;

class Active extends UserStatus
{
    public function color(): string
    {
        return 'success';
    }

    public function name(): string
    {
        return 'active';
    }
}
