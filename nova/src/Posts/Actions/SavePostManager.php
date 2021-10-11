<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\DataTransferObjects\PostPositionData;
use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;

class SavePostManager
{
    use AsAction;

    public function handle(
        PostData $postData,
        PostStatusData $postStatusData,
        PostPositionData $positionData
    ): Post {
        $post = SavePost::run($postData);

        $post = UpdatePostStatus::run($post, $postStatusData);

        $post = SetPostPosition::run($post, $positionData);

        // Send notifications

        return $post;
    }
}
