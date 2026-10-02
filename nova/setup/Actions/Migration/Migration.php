<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Nova\Foundation\Actions\Action;
use Nova\Setup\Livewire\Concerns\HandlesDates;

abstract class Migration extends Action
{
    use HandlesDates;
}
