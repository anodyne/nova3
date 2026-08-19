<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\CreatePosition;
use Nova\Departments\Actions\UpdatePosition;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\StorePositionRequest;
use Nova\Departments\Requests\UpdatePositionRequest;
use Nova\Departments\Responses\CreatePositionResponse;
use Nova\Departments\Responses\EditPositionResponse;
use Nova\Departments\Responses\ListPositionsResponse;
use Nova\Departments\Responses\ShowPositionResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;

class PositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Position::class);
    }

    public function index(): Responsable
    {
        return ListPositionsResponse::send();
    }

    public function show(Position $position): Responsable
    {
        $position->load('department', 'activeCharacters.users', 'activeUsers');
        $position->loadCount(['activeCharacters']);

        return ShowPositionResponse::sendWith([
            'position' => $position,
        ]);
    }

    public function create(Request $request): Responsable
    {
        return CreatePositionResponse::sendWith([
            'departments' => Department::ordered()->get(),
            'selectedDepartment' => Department::find($request->department),
        ]);
    }

    public function store(StorePositionRequest $request)
    {
        $position = CreatePosition::run($request->getPositionData());

        return to_route('admin.positions.index')
            ->notify("{$position->name} was created");
    }

    public function edit(Position $position): Responsable
    {
        return EditPositionResponse::sendWith([
            'departments' => Department::ordered()->get(),
            'position' => $position,
        ]);
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $position = UpdatePosition::run(
            $position,
            $request->getPositionData()
        );

        return back()->notify("{$position->name} position was updated");
    }
}
