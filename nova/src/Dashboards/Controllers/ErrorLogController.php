<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Illuminate\Http\Request;
use Nova\Dashboards\Responses\ErrorLogResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class ErrorLogController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request): Responsable
    {
        abort_unless($request->user()->isAbleTo('system.error-logs'), 403);

        return ErrorLogResponse::send();
    }
}
