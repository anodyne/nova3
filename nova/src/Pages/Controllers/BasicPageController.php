<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Pages\Responses\BasicPageResponse;

class BasicPageController extends Controller
{
    public function __invoke(Request $request)
    {
        return BasicPageResponse::sendWith([
            'page' => $request->route()->findPageFromRoute(),
        ]);
    }
}
