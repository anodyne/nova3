<?php

namespace Nova\Characters\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowCharacterResponse extends ServerResponse
{
    public $view = 'characters.show';
}
