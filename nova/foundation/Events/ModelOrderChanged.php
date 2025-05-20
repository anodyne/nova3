<?php

declare(strict_types=1);

namespace Nova\Foundation\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelOrderChanged
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public string $model) {}
}
