<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nova\PostTypes\Models\PostType;

trait HasPostType
{
    public ?int $postTypeId = null;

    public mixed $postType = null;

    public function mountHasPostType(): void
    {
        $data = Arr::get(
            $this->state()->forStep('posts:step:setup-post'),
            'postTypeId'
        );

        $this->postType = $this->postTypes->where('id', $data)->first();

        $this->postTypeId = $this->postType?->id;
    }

    public function getPostTypesProperty(): Collection
    {
        return PostType::query()
            ->whereUserHasAccess(auth()->user())
            ->orderBySort()
            ->get();
    }

    public function setPostType(PostType $postType): void
    {
        $this->postTypeId = $postType->id;
        $this->postType = $postType;

        $this->post->update(['post_type_id' => $this->postTypeId]);
    }
}
