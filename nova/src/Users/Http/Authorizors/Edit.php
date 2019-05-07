<?php

namespace Nova\Users\Http\Authorizors;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Edit extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('user.update');
    }
}
