<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;
use Nova\Foundation\Actions\Action;

class DeletePosition extends Action
{
    public function handle(Position $position): Position
    {
        $position->characters()->detach();

        return tap($position)->delete();
    }
}
