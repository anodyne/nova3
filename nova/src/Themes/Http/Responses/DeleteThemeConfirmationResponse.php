<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class DeleteThemeConfirmationResponse extends ServerResponse
{
    public $view = 'themes.delete';
}
