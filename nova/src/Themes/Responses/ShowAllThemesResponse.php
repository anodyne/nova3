<?php

declare(strict_types=1);

namespace Nova\Themes\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllThemesResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'themes.index';
}
