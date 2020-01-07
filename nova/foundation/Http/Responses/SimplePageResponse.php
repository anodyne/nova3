<?php

namespace Nova\Foundation\Http\Responses;

class SimplePageResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'simple-page',
        ];
    }
}
