<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Responses\ShowStoryResponse;
use Nova\Stories\Models\Story;

class ShowStoryController extends Controller
{
    public function __invoke(Story $story)
    {
        return ShowStoryResponse::sendWith([
            'story' => $story->loadCount('posts', 'recursivePosts')->loadSum(['recursivePosts', 'posts'], 'word_count'),
            'ancestors' => $story->ancestors->splice(1),
        ]);
    }
}
