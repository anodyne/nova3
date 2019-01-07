<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class CreateThemeResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'themes.create',
        ];
    }
}