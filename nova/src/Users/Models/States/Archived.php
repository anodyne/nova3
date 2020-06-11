<?php

namespace Nova\Users\Models\States;

class Archived extends UserState
{
    // public static $name = 'archived';

    public function name(): string
    {
        return 'archived';
    }

    public function statusClass(): string
    {
        return '';
    }
}
