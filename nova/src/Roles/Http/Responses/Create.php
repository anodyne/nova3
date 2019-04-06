<?php

namespace Nova\Roles\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Create extends BaseResponsable
{
    public function views(): array
    {
        return [
            'page' => 'Roles/Create',
        ];
    }
}
