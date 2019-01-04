<?php

namespace Nova\Foundation\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Http\Responses\WelcomePageResponse;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return app(WelcomePageResponse::class);
    }
}
