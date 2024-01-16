<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Pages\Models\Page;
use Nova\Pages\Responses\DesignPageResponse;

class DesignPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, Page $page)
    {
        return DesignPageResponse::sendWith([
            'page' => $page,
        ]);
    }
}
