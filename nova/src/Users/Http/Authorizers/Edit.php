<?php

namespace Nova\Users\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Edit extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('user.update');
    }
}
