<?php

declare(strict_types=1);

namespace Nova\Menus\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Menus\Models\MenuItem;

class MenuItemDeleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public MenuItem $menuItem
    ) {}
}
