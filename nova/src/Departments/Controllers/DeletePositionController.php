<?php

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Models\Position;
use Nova\Foundation\Controllers\Controller;
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Responses\DeletePositionResponse;

class DeletePositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $position = Position::findOrFail($request->id);

        return app(DeletePositionResponse::class)->with([
            'position' => $position->load('department'),
        ]);
    }

    public function destroy(DeletePosition $action, Position $position)
    {
        $this->authorize('delete', $position);

        $action->execute($position);

        return redirect()
            ->route('positions.index', $position->department_id)
            ->withToast("{$position->name} was deleted", 'Any characters who were assigned to the position will have to have a new position manually assigned to them.');
    }
}
