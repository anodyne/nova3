<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Models\PostType;

/**
 * @template TModel of PostType
 *
 * @extends Builder<TModel>
 */
class PostTypeBuilder extends Builder
{
    use QueriesStatus;

    public function inCharacter(): self
    {
        return $this->where('visibility', PostTypeVisibility::InCharacter);
    }

    public function searchFor($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function userHasAccess(Authenticatable $user): self
    {
        return $this->where(function (Builder $query) use ($user): void {
            $query->whereNull('role_id')
                ->orWhereIn('role_id', $user->roles()->pluck('id')->all());
        });
    }
}
