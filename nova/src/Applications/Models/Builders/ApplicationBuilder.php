<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Users\Models\User;

/**
 * @template TModel of Application
 *
 * @extends Builder<TModel>
 */
class ApplicationBuilder extends Builder
{
    public function pending(): self
    {
        return $this->where('result', ApplicationResult::Pending);
    }

    public function reviewedBy(User $user): self
    {
        return $this->whereRelation('reviews', User::column('id'), '=', $user->id);
    }

    public function searchFor($search): self
    {
        return $this
            ->whereRelation('character', 'characters.name', 'like', "%{$search}%")
            ->orWhereRelation('user', 'users.name', 'like', "%{$search}%");
    }
}
