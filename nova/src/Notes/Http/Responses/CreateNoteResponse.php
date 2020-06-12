<?php

namespace Nova\Notes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class CreateNoteResponse extends ServerResponse
{
    public $view = 'notes.create';
}
