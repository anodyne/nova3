<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class EditThemeResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'themes.edit',
            'script' => 'themes.edit',
        ];
    }
}
