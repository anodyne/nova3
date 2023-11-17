<?php

declare(strict_types=1);

namespace Nova\Posts\Models\States;

use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;
use Spatie\ModelStates\Transition;

class StartedToDraft extends Transition
{
    public function __construct(
        protected Post $post
    ) {
    }

    public function handle(): Post
    {
        $this->post->status = Draft::class;

        if (blank($this->post->neighbor)) {
            $this->post->setHighestOrderNumber();
        }

        $this->post->save();

        if (filled($this->post->neighbor)) {
            SetPostPosition::run(
                $this->post,
                PostPositionData::from([
                    'neighbor' => $this->post->neighbor,
                    'direction' => $this->post->direction,
                    'hasPositionChange' => true,
                ])
            );
        }

        return $this->post->refresh();
    }
}
