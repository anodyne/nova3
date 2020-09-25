<?php

namespace Nova\Posts\Models\States;

class Pending extends PostStatus
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
