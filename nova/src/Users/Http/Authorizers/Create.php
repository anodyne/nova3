<?php

namespace Nova\Users\Http\Authorizers;

use Nova\Users\Models\User;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Create extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->allows('create', User::class);
    }
}
