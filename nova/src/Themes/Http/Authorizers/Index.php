<?php

namespace Nova\Themes\Http\Authorizers;

use Nova\Themes\Theme;
use Nova\Foundation\Http\Authorizers\BaseAuthorizer;

class Index extends BaseAuthorizer
{
    public function authorize()
    {
        return $this->user()->can('manage', Theme::class);
    }

    public function userAbilities()
    {
        $theme = new Theme;

        return [
            'create' => $this->user()->can('create', Theme::class),
            'update' => $this->user()->can('update', $theme),
            'delete' => $this->user()->can('delete', $theme),
        ];
    }
}
