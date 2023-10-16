<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Nova\Departments\Actions\CreateDepartmentManager;
use Nova\Departments\Actions\UpdateDepartmentManager;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\StoreDepartmentRequest;
use Nova\Departments\Requests\UpdateDepartmentRequest;
use Nova\Departments\Responses\CreateDepartmentResponse;
use Nova\Departments\Responses\EditDepartmentResponse;
use Nova\Departments\Responses\ListDepartmentsResponse;
use Nova\Departments\Responses\ShowDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

class DepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Department::class);
    }

    public function index()
    {
        return ListDepartmentsResponse::send();
    }

    public function show(Department $department)
    {
        $department->load([
            'positions' => [
                'activeCharacters',
                'activeUsers',
            ],
        ]);
        $department->loadCount([
            'positions',
            'activeCharacters',
            'activeUsers' => fn (Builder $query): Builder => $query->countDistinct(),
        ]);

        return ShowDepartmentResponse::sendWith([
            'department' => $department,
        ]);
    }

    public function create()
    {
        return CreateDepartmentResponse::send();
    }

    public function store(StoreDepartmentRequest $request)
    {
        $department = CreateDepartmentManager::run($request);

        return redirect()
            ->route('departments.index')
            ->notify("{$department->name} department was created");
    }

    public function edit(Department $department)
    {
        return EditDepartmentResponse::sendWith([
            'department' => $department,
        ]);
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department = UpdateDepartmentManager::run($department, $request);

        return back()->notify("{$department->name} department was updated");
    }
}
