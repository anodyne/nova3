<?php

declare(strict_types=1);

namespace Tests\Feature\Foundation\Actions;

use Nova\Foundation\Actions\Action;

class ConditionalTestAction extends Action
{
    public function handle(string $first, string $second): string
    {
        return $first.' '.$second;
    }
}
