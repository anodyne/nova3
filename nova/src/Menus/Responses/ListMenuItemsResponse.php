<?php

declare(strict_types=1);

namespace Nova\Menus\Responses;

use Nova\Foundation\Responses\Responsable;

class ListMenuItemsResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'menu-items.index';
}
