<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Pages\Responses\BasicPageResponse;

class BasicPageController extends Controller
{
    public function __invoke(Request $request): Responsable
    {
        return BasicPageResponse::sendWith([
            'page' => $request->route()->findPageFromRoute(),
        ]);
    }
}
