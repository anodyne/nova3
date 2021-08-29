<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Position;

class DeletePosition
{
    use AsAction;

    public function handle(Position $position): Position
    {
        $position->characters()->detach();

        return tap($position)->delete();
    }
}
