<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\CreateStoryManager;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\CreateStoryRequest;
use Nova\Stories\Responses\CreateStoryResponse;

class CreateStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Story::class);

        return app(CreateStoryResponse::class);
    }

    public function store(CreateStoryRequest $request)
    {
        $this->authorize('create', Story::class);

        $story = CreateStoryManager::run($request);

        return redirect()
            ->route('stories.index')
            ->withToast("{$story->title} story was created");
    }
}
