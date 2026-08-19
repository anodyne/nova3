<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\PublicSite\Responses\ShowStoryResponse;
use Nova\Stories\Models\Story;

class ShowStoryController extends Controller
{
    public function __invoke(Story $story): Responsable
    {
        return ShowStoryResponse::sendWith(
            data: [
                'story' => $story->loadCountsAndSums(),
                'ancestors' => $story->ancestors->splice(1),
            ],
            seo: [
                'title' => $story->title.' - Story',
            ]
        );
    }
}
