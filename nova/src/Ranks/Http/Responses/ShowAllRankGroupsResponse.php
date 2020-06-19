<?php

namespace Nova\Ranks\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllRankGroupsResponse extends ServerResponse
{
    public $view = 'ranks.groups.index';
}
