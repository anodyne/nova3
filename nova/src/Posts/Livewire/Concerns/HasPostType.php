<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Arr;
use Nova\PostTypes\Models\PostType;

trait HasPostType
{
    public mixed $postType = null;

    public ?int $postTypeId = null;

    public function bootedHasPostType()
    {
        $data = Arr::get(
            $this->state()->forStep('posts:step:choose-post-type'),
            'postTypeId'
        );

        if ($data !== null) {
            $this->postTypeId = $data;
            $this->postType = PostType::find($this->postTypeId);
        }
    }

    public function setPostType(PostType $postType): void
    {
        $this->postType = $postType;
        $this->postTypeId = $postType->id;
    }
}
