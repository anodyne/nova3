<?php

namespace Nova\Foundation\Macros;

class ViewMacros
{
    public function component()
    {
        return function ($name, $data) {
            $name = str_replace(' ', '', ucwords(str_replace('.', ' ', $name)));

            return view('app-client', [
                'name' => $name,
                'data' => array_merge($data, [
                    'config' => nova()->provideScriptVariables()
                ])
            ]);
        };
    }
}