<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Posts\Models\Post;

trait HandlesPostSuggestion
{
    public $suggestion;

    protected function getSuggestedPost()
    {
        if ($this->neighbor) {
            $startingPost = Post::find($this->neighbor);

            $this->suggestion = $startingPost->getPrevSibling() ?? $startingPost->getNextSibling();
        } else {
            $this->suggestion = Post::query()
                ->story($this->story?->id)
                ->wherePostType(optional($this->postType)->id)
                ->orderByDesc('sort')
                ->first();
        }
    }
}
