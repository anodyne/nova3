<?php

declare(strict_types=1);

namespace Nova\Addons\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAddonResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'add-ons.show';
}
