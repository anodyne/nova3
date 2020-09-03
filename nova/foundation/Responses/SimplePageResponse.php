<?php

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
