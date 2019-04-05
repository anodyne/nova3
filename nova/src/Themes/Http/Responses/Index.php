<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\BaseResponsable;

class Index extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'themes.index',
        ];
    }
}
