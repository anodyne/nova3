<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Users\Models\User;

class ApplicationBuilder extends Builder
{
    public function pending(): Builder
    {
        return $this->where('result', ApplicationResult::Pending);
    }

    public function reviewedBy(Authenticatable $user): Builder
    {
        return $this->whereRelation('reviews', User::column('id'), '=', $user->id);
    }

    public function searchFor($search): Builder
    {
        return $this
            ->whereRelation('character', 'characters.name', 'like', "%{$search}%")
            ->orWhereRelation('user', 'users.name', 'like', "%{$search}%");
    }
}
