<?php

namespace Nova\Posts\Models\States;

class Published extends PostStatus
{
    public function color(): string
    {
        return 'blue';
    }

    public function name(): string
    {
        return 'published';
    }
}
