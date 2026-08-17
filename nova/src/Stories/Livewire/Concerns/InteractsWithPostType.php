<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Nova\Stories\Models\PostType;

/**
 * @property-read Collection $availablePostTypes
 * @property-read ?PostType $postType
 */
trait InteractsWithPostType
{
    public ?int $postTypeId = null;

    public function getPostType(): ?PostType
    {
        return once(fn () => PostType::find($this->postTypeId));
    }

    #[Computed]
    public function availablePostTypes(): Collection
    {
        return PostType::query()
            ->with('role')
            ->withTrashed()
            ->where(function (Builder $query): Builder {
                /** @var User */
                $user = Auth::user();

                return $query->active()
                    ->userHasAccess($user->loadMissing('roles'))
                    ->orWhere('id', $this->postTypeId);
            })
            ->ordered()
            ->get();
    }

    #[Computed]
    public function postType(): ?PostType
    {
        return PostType::find($this->postTypeId);
    }
}
