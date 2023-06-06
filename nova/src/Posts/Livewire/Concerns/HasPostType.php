<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\PostTypes\Models\PostType;

trait HasPostType
{
    public ?int $postTypeId = null;

    public mixed $postType = null;

    public function mountHasPostType(): void
    {
        $data = data_get(
            $this->state()->forStep('posts:step:setup-post'),
            'postTypeId'
        );

        $this->postType = $this->availablePostTypes->where('id', $data)->first();

        $this->postTypeId = $this->postType?->id;
    }

    public function getAvailablePostTypesProperty(): Collection
    {
        return PostType::with('role')
            ->active()
            ->userHasAccess(auth()->user()->loadMissing('roles'))
            ->ordered()
            ->get();
    }

    public function setPostType(PostType $postType): void
    {
        $this->postTypeId = $postType->id;
        $this->postType = $postType;

        $this->post->update(['post_type_id' => $this->postTypeId]);
    }
}
