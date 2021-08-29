<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\DuplicateDepartmentManager;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Department;
use Nova\Departments\Responses\DuplicateDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

class DuplicateDepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $department = Department::findOrFail($request->id);

        return app(DuplicateDepartmentResponse::class)->with([
            'department' => $department,
        ]);
    }

    public function duplicate(Request $request, Department $original)
    {
        $this->authorize('duplicate', $original);

        $department = DuplicateDepartmentManager::run($original, $request);

        DepartmentDuplicated::dispatch($department, $original);

        return redirect()
            ->route('departments.edit', $department)
            ->withToast("{$department->name} department has been created", "All of the positions from the {$original->name} department have been duplicated into your new department.");
    }
}
