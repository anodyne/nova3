<?php

declare(strict_types=1);

namespace Nova\Notes\Responses;

use Nova\Foundation\Responses\Responsable;

class CreateNoteResponse extends Responsable
{
    public string $view = 'notes.create';
}
