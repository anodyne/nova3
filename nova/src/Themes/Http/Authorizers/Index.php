<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('theme.create')
            || $this->user()->can('theme.delete')
            || $this->user()->can('theme.update');
    }
}
