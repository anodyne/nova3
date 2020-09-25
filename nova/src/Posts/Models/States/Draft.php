<?php

namespace Nova\Posts\Models\States;

class Draft extends PostStatus
{
    public function color(): string
    {
        return 'gray';
    }

    public function name(): string
    {
        return 'draft';
    }
}
