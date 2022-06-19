<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Data\PostAuthorsData;
use Nova\Posts\Data\PostData;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Data\PostStatusData;
use Nova\Posts\Models\Post;

class SavePostManager
{
    use AsAction;

    public function handle(
        PostData $postData,
        PostStatusData $postStatusData,
        PostPositionData $positionData,
        PostAuthorsData $authorsData
    ): Post {
        $post = SavePost::run($postData);

        $post = UpdatePostStatus::run($post, $postStatusData);

//        $post = SetPostPosition::run($post, $positionData);

        $post = SetPostAuthors::run($post, $authorsData);

        // Send notifications

        return $post;
    }
}
