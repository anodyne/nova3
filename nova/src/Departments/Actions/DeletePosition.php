<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;

class DeletePosition
{
    public function execute(Position $position): Position
    {
        return tap($position)->delete();
    }
}
