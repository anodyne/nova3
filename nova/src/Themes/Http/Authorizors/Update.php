<?php

namespace Nova\Themes\Http\Authorizors;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Update extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('theme.update');
    }
}
