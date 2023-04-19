<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Responses\SimplePageResponse;

class SimplePageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return SimplePageResponse::send();
    }
}
