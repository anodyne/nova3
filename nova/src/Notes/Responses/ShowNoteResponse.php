<?php

declare(strict_types=1);

namespace Nova\Notes\Responses;

use Nova\Foundation\Responses\Responsable;

class ShowNoteResponse extends Responsable
{
    public $view = 'notes.show';
}
