<?php

namespace Nova\Ranks\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllRankItemsResponse extends ServerResponse
{
    public $view = 'ranks.items.index';
}
