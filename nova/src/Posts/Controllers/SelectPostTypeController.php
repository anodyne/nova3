<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Responses\SelectPostTypeResponse;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;

class SelectPostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', new Post());

        $usersPostTypes = PostType::orderBySort()
            ->get()
            ->filter(fn ($postType) => Gate::allows('write', $postType));

        if ($usersPostTypes->count() === 1) {
            return redirect()->route('posts.compose', $usersPostTypes->first());
        }

        return app(SelectPostTypeResponse::class)->with([
            'postTypes' => $usersPostTypes,
            'stories' => Story::wherePostable()->get(),
        ]);
    }
}
