<?php

declare(strict_types=1);

namespace Nova\Stories\Models\States\PostStatus;

use Nova\Stories\Actions\UpdatePostPosition;
use Nova\Stories\Data\PostPositionData;
use Nova\Stories\Models\Post;
use Spatie\ModelStates\Transition;

class StartedToDraft extends Transition
{
    public function __construct(
        protected Post $post
    ) {}

    public function handle(): Post
    {
        $this->post->status = new Draft($this->post);

        if (blank($this->post->neighbor)) {
            $this->post->setHighestOrderNumber();
        }

        $this->post->save();

        if (filled($this->post->neighbor)) {
            UpdatePostPosition::run(
                $this->post,
                PostPositionData::from(
                    neighbor: $this->post->neighbor,
                    direction: $this->post->direction,
                    hasPositionChange: true
                )
            );
        }

        return $this->post->refresh();
    }
}
