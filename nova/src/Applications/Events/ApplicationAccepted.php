<?php

declare(strict_types=1);

namespace Nova\Applications\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Applications\Models\Application;

class ApplicationAccepted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Application $application
    ) {}
}
