<?php

namespace Nova\Foundation\Responses;

class SimplePageResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'simple-page',
        ];
    }
}
