<?php

namespace Nova\Characters\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class DeleteCharacterResponse extends ServerResponse
{
    public $view = 'characters.delete';
}
