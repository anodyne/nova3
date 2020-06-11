<?php

namespace Nova\Users\Models\States;

class Inactive extends UserState
{
    // public static $name = 'inactive';

    public function name(): string
    {
        return 'inactive';
    }

    public function statusClass(): string
    {
        return 'danger';
    }
}
