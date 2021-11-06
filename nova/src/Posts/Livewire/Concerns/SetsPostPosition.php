<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Models\Post;

trait SetsPostPosition
{
    public $direction;

    public $neighbor;

    public ?Post $previousPost;

    public ?Post $nextPost;

    public function bootedSetsPostPosition()
    {
        if ($this->story) {
            if ($this->neighbor === null && $this->direction === null) {
                $this->previousPost = $this->story->posts->last();
            }

            if ($this->neighbor) {
                $neighbor = Post::find($this->neighbor);

                if ($this->direction === 'before') {
                    $this->nextPost = $neighbor;
                    $this->previousPost = $neighbor->prevSiblings()->wherePublished()->reversed()->first();
                } else {
                    $this->previousPost = $neighbor;
                    $this->nextPost = $neighbor->nextSiblings()->wherePublished()->first();
                }
            }
        }
    }

    public function getShowPostPositionControlProperty(): bool
    {
        if ($this->story) {
            if ($this->story->posts()->count() === 0) {
                return false;
            }

            return true;
        }

        return false;
    }
}
