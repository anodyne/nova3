<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Published;

trait SetsPostPosition
{
    public mixed $previousPost;

    public mixed $nextPost;

    public function bootedSetsPostPosition(): void
    {
        $this->previousPost = $this->post->previousSibling(Published::class);
        $this->nextPost = $this->post->nextSibling(Published::class);
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

        $this->dispatch('refreshParticipatingUsers');
    }

    protected function setDirectionAndNeighbor(string $direction, int $neighbor): void
    {
        if ($direction === 'before') {
            $this->nextPost = Post::find($neighbor);
            $this->previousPost = $this->nextPost->previousSibling(Published::class);
        } else {
            $this->previousPost = Post::find($neighbor);
            $this->nextPost = $this->previousPost->nextSibling(Published::class);
        }
    }
}
