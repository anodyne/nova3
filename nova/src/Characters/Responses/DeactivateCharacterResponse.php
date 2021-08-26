<?php

declare(strict_types=1);

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\Responsable;

class DeactivateCharacterResponse extends Responsable
{
    public $view = 'characters.deactivate';
}
