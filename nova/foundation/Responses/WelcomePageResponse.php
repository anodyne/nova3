<?php

declare(strict_types=1);

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
