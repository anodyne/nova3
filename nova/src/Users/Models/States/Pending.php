<?php

namespace Nova\Users\Models\States;

class Pending extends UserState
{
    public static $name = 'pending';

    public function statusClass(): string
    {
        return 'warning';
    }
}
