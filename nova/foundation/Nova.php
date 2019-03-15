<?php

namespace Nova\Foundation;

class Nova
{
    public $version = '3.0.0';

    /**
     * Provide data from the backend for the frontend to use.
     *
     * @return \Illuminate\Support\Collection
     */
    public function provideScriptVariables()
    {
        $theme = app('nova.theme');

        return collect([
            'icons' => $theme->iconMap(),
            'page' => request()->route()->findPageFromRoute(),
            'theme' => $theme,
            'user' => auth()->user(),
        ]);
    }
}
