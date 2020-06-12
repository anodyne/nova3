<?php

namespace Nova\Notes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UpdateNoteResponse extends ServerResponse
{
    public $view = 'notes.edit';
}
