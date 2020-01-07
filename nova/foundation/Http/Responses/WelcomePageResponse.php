<?php

namespace Nova\Foundation\Http\Responses;

class WelcomePageResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'welcome',
        ];
    }
}
