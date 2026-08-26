<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Stories\Models\Builders\PostTypeBuilder;
use Nova\Stories\Models\PostType;
use Nova\Users\Models\User;

/**
 * @property-read Collection<int, PostType> $availablePostTypes
 * @property-read ?PostType $postType
 */
trait InteractsWithPostType
{
    public ?string $postTypeId = null;

    /** @return Collection<int, PostType> */
    #[Computed]
    public function availablePostTypes(): Collection
    {
        return PostType::query()
            ->with('role')
            ->withTrashed()
            ->where(function (PostTypeBuilder $query): PostTypeBuilder {
                /** @var User */
                $user = Auth::user();

                return $query->active()
                    ->userHasAccess($user->loadMissing('roles'))
                    ->orWhere('id', $this->postTypeId);
            })
            ->ordered()
            ->get();
    }

    public function getPostType(): ?PostType
    {
        return once(fn () => PostType::find($this->postTypeId));
    }

    #[Computed]
    public function postType(): ?PostType
    {
        return PostType::find($this->postTypeId);
    }
}
