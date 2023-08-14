<?php

declare(strict_types=1);

namespace Nova\Notes\Responses;

use Nova\Foundation\Responses\Responsable;

class EditNoteResponse extends Responsable
{
    public string $view = 'notes.edit';
}
