<?php

namespace Nova\Characters\Responses;

use Nova\Foundation\Responses\ServerResponse;

class ShowAllCharactersResponse extends ServerResponse
{
    public $view = 'characters.index';
}
