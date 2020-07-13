<?php

namespace Nova\Notes\Responses;

use Nova\Foundation\Responses\ServerResponse;

class DeleteNoteResponse extends ServerResponse
{
    public $view = 'notes.delete';
}
