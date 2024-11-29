<?php

declare(strict_types=1);

namespace Nova\Addons\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateAddonResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'add-ons.create';
}
