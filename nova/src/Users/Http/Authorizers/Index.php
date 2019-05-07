<?php

namespace Nova\Users\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('user.create')
            || $this->user()->can('user.delete')
            || $this->user()->can('user.update');
    }
}
