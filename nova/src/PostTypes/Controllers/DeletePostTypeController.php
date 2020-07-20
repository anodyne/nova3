<?php

namespace Nova\PostTypes\Controllers;

use Illuminate\Http\Request;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Responses\DeletePostTypeResponse;

class DeletePostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $postType = PostType::findOrFail($request->id);

        return app(DeletePostTypeResponse::class)->with([
            'postType' => $postType,
        ]);
    }

    public function destroy(DeletePostType $action, PostType $postType)
    {
        $this->authorize('delete', $postType);

        $action->execute($postType);

        return redirect()
            ->route('post-types.index')
            ->withToast("{$postType->name} was deleted");
    }
}
