<?php

declare(strict_types=1);

namespace Nova\Themes\Responses;

use Nova\Foundation\Responses\Responsable;

class UpdateThemeResponse extends Responsable
{
    public string $view = 'themes.edit';
}
