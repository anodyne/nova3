<?php

declare(strict_types=1);

namespace Nova\Pages\Responses;

use Nova\Foundation\Responses\Responsable;

class CreatePageResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'pages.create';
}
