<?php

declare(strict_types=1);

namespace Nova\Users\Models\Scopes;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveUsers implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        return $builder->whereHas('user', fn (Builder $query): Builder => $query->active());
    }
}
