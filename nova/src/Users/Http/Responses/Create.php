<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Create extends BaseResponsable
{
    public function views(): array
    {
        return [
            'component' => 'Users/Create',
        ];
    }
}
