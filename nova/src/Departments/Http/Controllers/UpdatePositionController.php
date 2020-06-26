<?php

namespace Nova\Departments\Http\Controllers;

use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\UpdatePosition;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Http\Requests\UpdatePositionRequest;
use Nova\Departments\Http\Responses\UpdatePositionResponse;

class UpdatePositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Position $position)
    {
        $this->authorize('update', $position);

        return app(UpdatePositionResponse::class)->with([
            'departments' => Department::orderBySort()->get(),
            'position' => $position,
        ]);
    }

    public function update(
        UpdatePositionRequest $request,
        UpdatePosition $action,
        Position $position
    ) {
        $this->authorize('update', $position);

        $position = $action->execute($position, PositionData::fromRequest($request));

        return back()->withToast("{$position->name} position was updated");
    }
}
