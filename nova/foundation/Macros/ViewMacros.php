<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ViewMacros
{
    public function component()
    {
        return function ($name, $data): Factory|View {
            $name = str_replace(' ', '', ucwords(str_replace('.', ' ', $name)));

            return view('app-client', [
                'component' => $name,
                'props' => array_merge($data, [
                    'config' => nova()->provideScriptVariables(),
                ]),
            ]);
        };
    }
}
