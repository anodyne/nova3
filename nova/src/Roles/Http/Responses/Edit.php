<?php

namespace Nova\Roles\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Edit extends BaseResponsable
{
    public function views(): array
    {
        return [
            'page' => 'authorization.roles.edit',
        ];
    }
}
