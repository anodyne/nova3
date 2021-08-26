<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

class ViewMacros
{
    public function component()
    {
        return function ($name, $data) {
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
