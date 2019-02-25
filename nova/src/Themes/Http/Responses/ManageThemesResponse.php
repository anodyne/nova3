<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class ManageThemesResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'component' => 'ManageThemes'
        ];
    }
}
