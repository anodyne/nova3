<?php

namespace Nova\Ranks\Http\Responses\Groups;

use Nova\Foundation\Http\Responses\ServerResponse;

class DuplicateRankGroupResponse extends ServerResponse
{
    public $view = 'ranks.groups.duplicate';
}