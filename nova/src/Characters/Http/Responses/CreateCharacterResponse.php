<?php

namespace Nova\Characters\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class CreateCharacterResponse extends ServerResponse
{
    public $view = 'characters.create';
}
