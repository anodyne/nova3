<?php

namespace Nova\Users\Models\States;

class Active extends UserState
{
    // public static $name = 'active';

    public function name(): string
    {
        return 'active';
    }

    public function statusClass(): string
    {
        return 'success';
    }
}
