<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Responses\ShowAllPositionsResponse;
use Nova\Departments\Responses\ShowPositionResponse;
use Nova\Foundation\Controllers\Controller;

class ShowPositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        $this->authorize('viewAny', Department::class);

        return ShowAllPositionsResponse::send();
    }

    public function show(Position $position)
    {
        $this->authorize('view', $position);

        return ShowPositionResponse::sendWith([
            'position' => $position->load('department'),
        ]);
    }
}
