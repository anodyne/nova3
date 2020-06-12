<?php

namespace Nova\Users\Models\States;

class Inactive extends UserStatus
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
