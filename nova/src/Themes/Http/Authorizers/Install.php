<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Install extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->allows('create', Theme::class);
    }
}
