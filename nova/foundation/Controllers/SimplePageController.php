<?php

namespace Nova\Foundation\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Responses\SimplePageResponse;

class SimplePageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return app(SimplePageResponse::class);
    }
}
