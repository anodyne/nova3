<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllThemesResponse extends ServerResponse
{
    public $view = 'themes.index';
}
