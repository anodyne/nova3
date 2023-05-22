<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Nova\Departments\Actions\UpdatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\UpdatePositionRequest;
use Nova\Departments\Responses\UpdatePositionResponse;
use Nova\Foundation\Controllers\Controller;

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

        return UpdatePositionResponse::sendWith([
            'departments' => Department::ordered()->get(),
            'position' => $position,
        ]);
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $this->authorize('update', $position);

        $position = UpdatePosition::run(
            $position,
            PositionData::from($request)
        );

        return back()->withToast("{$position->name} position was updated");
    }
}
