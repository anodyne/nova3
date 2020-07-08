<?php

namespace Nova\Users\Models\States;

class Inactive extends UserStatus
{
    public function color(): string
    {
        return '';
    }

    public function name(): string
    {
        return 'inactive';
    }
}
