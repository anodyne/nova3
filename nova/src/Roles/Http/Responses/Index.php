<?php

namespace Nova\Roles\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Index extends BaseResponsable
{
    public function views(): array
    {
        return [
            'component' => 'Roles/Index',
        ];
    }
}