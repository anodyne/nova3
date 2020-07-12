<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;

class DeletePosition
{
    public function execute(Position $position): Position
    {
        $position->characters()->detach();

        return tap($position)->delete();
    }
}
