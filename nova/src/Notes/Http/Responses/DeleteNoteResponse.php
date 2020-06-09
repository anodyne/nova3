<?php

namespace Nova\Notes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class DeleteNoteResponse extends ServerResponse
{
    public $view = 'notes.delete';
}
