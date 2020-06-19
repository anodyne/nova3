<?php

namespace Nova\Ranks\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllRankNamesResponse extends ServerResponse
{
    public $view = 'ranks.names.index';
}
