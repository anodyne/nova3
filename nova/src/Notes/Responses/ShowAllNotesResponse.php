<?php

namespace Nova\Notes\Responses;

use Nova\Foundation\Responses\ServerResponse;

class ShowAllNotesResponse extends ServerResponse
{
    public $view = 'notes.index';
}
