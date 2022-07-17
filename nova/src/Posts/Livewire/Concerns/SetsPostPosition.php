<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;

trait SetsPostPosition
{
    public mixed $previousPost;

    public mixed $nextPost;

    public function bootedSetsPostPosition(): void
    {
        $this->previousPost = $this->post->prevSiblings()->wherePublished()->reversed()->first();
        $this->nextPost = $this->post->nextSiblings()->wherePublished()->first();
    }

    public function selectedPostPosition(...$args): void
    {
        [$neighbor, $direction] = $args;

        $this->setDirectionAndNeighbor($direction, $neighbor);

        SetPostPosition::run($this->post, PostPositionData::from([
            'direction' => $direction,
            'neighbor' => $neighbor,
            'hasPositionChange' => true,
        ]));

        $this->emit('refreshParticipatingUsers');
    }

    protected function setDirectionAndNeighbor(string $direction, int $neighbor): void
    {
        if ($direction === 'before') {
            $this->nextPost = Post::find($neighbor);
            $this->previousPost = $this->nextPost->prevSiblings()->wherePublished()->reversed()->first();
        } else {
            $this->previousPost = Post::find($neighbor);
            $this->nextPost = $this->previousPost->nextSiblings()->wherePublished()->first();
        }
    }
}
