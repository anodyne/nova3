<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->any(['create', 'update', 'delete'], new Theme);
    }
}
