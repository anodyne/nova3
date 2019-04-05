<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Update extends BaseAuthorizer
{
    public function authorize()
    {
        $theme = Theme::find($this->route('theme'))->first();

        return $theme && $this->user()->can('update', $theme);
    }
}
