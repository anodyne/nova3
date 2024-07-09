<?php

declare(strict_types=1);

namespace Nova\Pages\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Pages\Models\Page;

class PageDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Page $page
    ) {}
}
