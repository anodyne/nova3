<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;

abstract class Migration
{
    use AsAction;
    use HandlesDates;
}
