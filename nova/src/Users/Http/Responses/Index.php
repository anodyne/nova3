<?php

namespace Nova\Users\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Index extends BaseResponsable
{
    public function views(): array
    {
        return [
            'component' => 'Users/Index',
        ];
    }
}
