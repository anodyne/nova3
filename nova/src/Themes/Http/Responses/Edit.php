<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Edit extends BaseResponsable
{
    public function views() : array
    {
        return [
            'component' => 'Themes/Edit'
        ];
    }
}
