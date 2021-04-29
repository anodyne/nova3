<?php

namespace Nova\Posts\Actions;

use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\DataTransferObjects\PostPositionData;
use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;

class SavePostManager
{
    protected SavePost $savePost;

    protected SetPostPosition $setPostPosition;

    protected UpdatePostStatus $updatePostStatus;

    public function __construct(
        SavePost $savePost,
        SetPostPosition $setPostPosition,
        UpdatePostStatus $updatePostStatus
    ) {
        $this->savePost = $savePost;
        $this->setPostPosition = $setPostPosition;
        $this->updatePostStatus = $updatePostStatus;
    }

    public function execute(
        PostData $postData,
        PostStatusData $postStatusData,
        PostPositionData $positionData
    ): Post {
        $post = $this->savePost->execute($postData);

        $post = $this->updatePostStatus->execute($post, $postStatusData);

        $post = $this->setPostPosition->execute($post, $positionData);

        // Send notifications

        return $post;
    }
}
