<?php

declare(strict_types=1);

namespace Nova\Applications\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveUsers implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereHas('user', fn (Builder $query): Builder => $query->active());
    }
}
