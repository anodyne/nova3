<?php

declare(strict_types=1);

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowAllCharactersResponse extends Responsable
{
    public string $view = 'characters.index';
}
