<?php

namespace Nova\Foundation\Http\Controllers;

use Illuminate\Http\Request;

class DispatchRouteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        dd($request, $request->getMethod());
    }
}
