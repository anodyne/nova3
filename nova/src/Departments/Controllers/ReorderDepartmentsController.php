<?php

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Models\Department;
use Nova\Foundation\Controllers\Controller;
use Nova\Departments\Actions\ReorderDepartments;

class ReorderDepartmentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderDepartments $action)
    {
        $this->authorize('update', new Department);

        $action->execute($request->sort);

        return redirect()
            ->route('departments.index')
            ->withToast('Department sort order has been updated');
    }
}
