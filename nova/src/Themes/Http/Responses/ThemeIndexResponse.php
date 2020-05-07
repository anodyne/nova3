<?php

namespace Nova\Themes\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ThemeIndexResponse extends ServerResponse
{
    public function views(): array
    {
        return [
            'page' => 'themes.index',
        ];
    }
}
