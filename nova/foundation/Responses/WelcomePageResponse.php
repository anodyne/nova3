<?php

namespace Nova\Foundation\Responses;

class WelcomePageResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'welcome',
        ];
    }
}
