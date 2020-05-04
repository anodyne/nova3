<?php

namespace Nova\Dashboard\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class DashboardResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'dashboard',
        ];
    }
}
