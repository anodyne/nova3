<?php

declare(strict_types=1);

namespace Nova\Themes\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateThemeResponse extends Responsable
{
    public string $view = 'themes.create';
}
