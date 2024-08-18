<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Applications\Enums\ApplicationResult;

class ApplicationBuilder extends Builder
{
    public function searchFor($search): Builder
    {
        return $this
            ->whereRelation('characters', 'characters.name', 'like', "%{$search}%")
            ->orWhereRelation('users', 'users.name', 'like', "%{$search}%");
    }

    public function pending(): Builder
    {
        return $this->where('result', ApplicationResult::Pending);
    }
}
