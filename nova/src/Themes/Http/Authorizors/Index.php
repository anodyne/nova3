<?php

namespace Nova\Themes\Http\Authorizors;

use Nova\Foundation\Http\Requests\AuthorizesRequest;

class Index extends AuthorizesRequest
{
    public function authorize()
    {
        return $this->user()->can('theme.create')
            || $this->user()->can('theme.delete')
            || $this->user()->can('theme.update');
    }
}
