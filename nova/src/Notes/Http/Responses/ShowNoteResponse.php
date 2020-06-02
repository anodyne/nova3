<?php

namespace Nova\Notes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowNoteResponse extends ServerResponse
{
    public $view = 'notes.show';
}
