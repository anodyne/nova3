<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Install extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('theme.create');
    }
}
