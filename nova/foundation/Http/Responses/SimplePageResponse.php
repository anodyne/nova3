<?php

namespace Nova\Foundation\Http\Responses;

class SimplePageResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'simple-page',
        ];
    }
}
