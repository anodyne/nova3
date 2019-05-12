<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Update extends AuthorizesRequest
{
    public function authorize()
    {
        return gate()->allows('update', $this->route('theme'));
    }
}
