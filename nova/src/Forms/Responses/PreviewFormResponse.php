<?php

declare(strict_types=1);

namespace Nova\Forms\Responses;

use Nova\Foundation\Responses\Responsable;

class PreviewFormResponse extends Responsable
{
    public ?string $subnav = 'forms';

    public string $view = 'forms.preview';
}
