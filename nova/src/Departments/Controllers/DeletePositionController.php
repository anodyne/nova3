<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Models\Position;
use Nova\Departments\Responses\DeletePositionResponse;
use Nova\Foundation\Controllers\Controller;

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

    public function destroy(Position $position)
    {
        $this->authorize('delete', $position);

        DeletePosition::run($position);

        return redirect()
            ->route('positions.index', $position->department_id)
            ->withToast("{$position->name} was deleted", 'Any characters who were assigned to the position will have to have a new position manually assigned to them.');
    }
}
