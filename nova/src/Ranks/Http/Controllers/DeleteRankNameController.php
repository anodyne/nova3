<?php

namespace Nova\Ranks\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\DeleteRankName;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Ranks\Http\Responses\DeleteRankNameResponse;

class DeleteRankNameController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $name = RankName::findOrFail($request->id);

        return app(DeleteRankNameResponse::class)->with([
            'name' => $name,
        ]);
    }

    public function destroy(DeleteRankName $action, RankName $name)
    {
        $this->authorize('delete', $name);

        $action->execute($name);

        return redirect()
            ->route('ranks.names.index')
            ->withToast("{$name->name} was deleted", 'All ranks assigned to this name have also been deleted.');
    }
}
