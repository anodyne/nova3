<?php

namespace Nova\Foundation\Responses;

class WelcomePageResponse extends Responsable
{
    public function views(): array
    {
        return [
            'page' => 'welcome',
        ];
    }
}
