<?php

namespace Nova\Characters\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UpdateCharacterResponse extends ServerResponse
{
    public $view = 'characters.edit';
}
