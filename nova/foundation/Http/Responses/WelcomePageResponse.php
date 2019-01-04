<?php

namespace Nova\Foundation\Http\Responses;

class WelcomePageResponse extends BaseResponsable
{
    public function views() : array
    {
        return [
            'page' => 'welcome'
        ];
    }
}