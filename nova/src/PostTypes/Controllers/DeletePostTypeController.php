<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Models\PostType;
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

        return DeletePostTypeResponse::sendWith([
            'postType' => $postType,
        ]);
    }

    public function destroy(PostType $postType)
    {
        $this->authorize('delete', $postType);

        $name = $postType->name;

        DeletePostType::run($postType);

        return redirect()
            ->route('post-types.index')
            ->withToast("{$name} post type was deleted");
    }
}
