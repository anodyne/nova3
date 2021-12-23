<?php

declare(strict_types=1);

namespace Nova\Forms\Responses;

use Nova\Foundation\Responses\Responsable;

class DeleteFormResponse extends Responsable
{
    public string $view = 'forms.delete';
}
