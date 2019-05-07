<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Create extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('theme.create');
    }
}
