<?php

declare(strict_types=1);

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\Responsable;

class EditCharacterResponse extends Responsable
{
    public ?string $subnav = 'characters';

    public string $view = 'characters.edit';
}
