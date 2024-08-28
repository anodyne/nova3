<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Responses\ShowStoryPostResponse;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;

class ShowStoryPostController extends Controller
{
    public function __invoke(Story $story, Post $post)
    {
        $inCharacterPostTypes = PostType::query()->inCharacter()->pluck('key')->all();

        return ShowStoryPostResponse::sendWith(
            data: [
                'story' => $story,
                'post' => $post->loadMissing('characterAuthors', 'userAuthors'),
                'nextPost' => $post->nextSibling(Published::class, $inCharacterPostTypes),
                'previousPost' => $post->previousSibling(Published::class, $inCharacterPostTypes),
            ],
            seo: [
                'title' => $post->title.' - '.$story->title.' - Story post',
            ]
        );
    }
}
