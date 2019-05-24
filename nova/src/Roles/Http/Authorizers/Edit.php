<?php

namespace Nova\Roles\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Edit extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->allows('update', $this->route('role'));
    }
}
