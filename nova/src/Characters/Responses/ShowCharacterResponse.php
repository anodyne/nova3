<?php

declare(strict_types=1);

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowCharacterResponse extends Responsable
{
    public string $view = 'characters.show';
}
