<?php

declare(strict_types=1);

namespace Nova\Forms\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateFormResponse extends Responsable
{
    public ?string $subnav = 'system';

    public string $view = 'forms.create';
}
