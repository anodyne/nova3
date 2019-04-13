<?php

namespace Nova\Users\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('user.create')
            || $this->user()->can('user.delete')
            || $this->user()->can('user.update');
    }
}
