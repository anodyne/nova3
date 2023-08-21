<?php

declare(strict_types=1);

namespace Nova\Themes\Responses;

use Nova\Foundation\Responses\Responsable;

class EditThemeResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'themes.edit';
}
