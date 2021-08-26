<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Models\Department;
use Nova\Departments\Responses\DeleteDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

class DeleteDepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $department = Department::findOrFail($request->id);

        return app(DeleteDepartmentResponse::class)->with([
            'department' => $department,
        ]);
    }

    public function destroy(DeleteDepartment $action, Department $department)
    {
        $this->authorize('delete', $department);

        $action->execute($department);

        return redirect()
            ->route('departments.index')
            ->withToast("{$department->name} was deleted", 'All positions in this department have also been deleted.');
    }
}
