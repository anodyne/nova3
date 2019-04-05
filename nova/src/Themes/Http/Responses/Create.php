<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Create extends BaseResponsable
{
    public function views() : array
    {
        return [
            'component' => 'Themes/CreateTheme',
        ];
    }
}
