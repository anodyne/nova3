<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

class SimplePageResponse extends Responsable
{
    public function views(): array
    {
        return [
            'page' => 'simple-page',
        ];
    }
}
