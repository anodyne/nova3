<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Store extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('create', Theme::class);
    }
}
