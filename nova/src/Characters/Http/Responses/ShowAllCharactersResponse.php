<?php

namespace Nova\Characters\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllCharactersResponse extends ServerResponse
{
    public $view = 'characters.index';
}
