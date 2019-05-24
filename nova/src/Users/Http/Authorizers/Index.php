<?php

namespace Nova\Users\Http\Authorizers;

use Nova\Users\Models\User;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->any(['create', 'update', 'delete'], new User);
    }
}
