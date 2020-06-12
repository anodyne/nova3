<?php

namespace Nova\Notes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllNotesResponse extends ServerResponse
{
    public $view = 'notes.index';
}
