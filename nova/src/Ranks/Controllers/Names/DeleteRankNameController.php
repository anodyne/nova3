<?php

declare(strict_types=1);

namespace Nova\Ranks\Controllers\Names;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Ranks\Actions\DeleteRankName;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Responses\Names\DeleteRankNameResponse;

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

    public function destroy(RankName $name)
    {
        $this->authorize('delete', $name);

        DeleteRankName::run($name);

        return redirect()
            ->route('ranks.names.index')
            ->withToast("{$name->name} was deleted", 'All ranks assigned to this name have also been deleted.');
    }
}
