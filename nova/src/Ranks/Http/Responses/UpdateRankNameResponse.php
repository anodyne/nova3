<?php

namespace Nova\Ranks\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class UpdateRankNameResponse extends ServerResponse
{
    public $view = 'ranks.names.edit';
}
