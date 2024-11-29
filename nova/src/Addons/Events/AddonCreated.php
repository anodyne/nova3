<?php

declare(strict_types=1);

namespace Nova\Addons\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Addons\Models\Addon;

class AddonCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Addon $addon
    ) {}
}
