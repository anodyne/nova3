<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Actions\UpdateStoryManager;
use Nova\Stories\Models\Story;
use Nova\Stories\Requests\UpdateStoryRequest;
use Nova\Stories\Responses\UpdateStoryResponse;

class UpdateStoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Story $story)
    {
        $this->authorize('update', $story);

        return app(UpdateStoryResponse::class)->with([
            'story' => $story,
        ]);
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $this->authorize('update', $story);

        $story = UpdateStoryManager::run($story, $request);

        return redirect()
            ->route('stories.edit', $story)
            ->withToast("{$story->title} was updated");
    }
}
