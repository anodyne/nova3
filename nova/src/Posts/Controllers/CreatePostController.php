<?php

namespace Nova\Posts\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Actions\CreatePost;
use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\Models\Post;
use Nova\Posts\Requests\CreatePostRequest;
use Nova\Posts\Responses\CreatePostResponse;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;

class CreatePostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create(PostType $postType)
    {
        $this->authorize('write', [new Post, $postType]);

        return app(CreatePostResponse::class)->with([
            'postType' => $postType,
            'stories' => Story::wherePostable()->get(),
        ]);
    }

    public function store(
        CreatePostRequest $request,
        CreatePost $action,
        PostType $postType
    ) {
        $this->authorize('write', [new Post, $postType]);

        $post = $action->execute(PostData::fromRequest($request));

        return redirect()->route('dashboard');
    }
}
