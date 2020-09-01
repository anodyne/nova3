<?php

namespace Nova\PostTypes\Controllers;

use Illuminate\Http\Request;
use Nova\PostTypes\Models\PostType;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\ReorderPostTypes;

class ReorderPostTypesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Request $request, ReorderPostTypes $action)
    {
        $this->authorize('update', new PostType);

        $action->execute($request->sort);

        return redirect()
            ->route('post-types.index')
            ->withToast('Post types sort order has been updated');
    }
}
