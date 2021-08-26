<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\ReorderPositions;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Controllers\Controller;

class ReorderPositionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(
        Request $request,
        ReorderPositions $action,
        Department $department
    ) {
        $this->authorize('update', new Position());

        $action->execute($request->sort);

        return redirect()
            ->route('positions.index', $department)
            ->withToast('Position sort order has been updated');
    }
}
