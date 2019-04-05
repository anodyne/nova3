<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Destroy extends BaseAuthorizer
{
    public function authorize()
    {
        $theme = Theme::find($this->route('theme'))->first();

        return $theme && $this->user()->can('delete', $theme);
    }
}
