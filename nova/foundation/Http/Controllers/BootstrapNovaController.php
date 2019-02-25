<?php

namespace Nova\Foundation\Http\Controllers;

use Illuminate\Http\Request;

class BootstrapNovaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $theme = app('nova.theme');

        return response()->json([
            'icons' => $theme->iconMap(),
            'page' => $request->route()->findPageFromRoute(),
            'theme' => $theme,
            'settings' => [
                'one' => 'one',
                'two' => 'two',
                'three' => 'three',
            ],
            'user' => auth()->user()
        ], 200);
    }
}
