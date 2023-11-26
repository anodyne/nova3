<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostAuthorsData;
use Nova\Stories\Data\PostData;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Data\PostStatusData;
use Nova\Stories\Models\Post;

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
