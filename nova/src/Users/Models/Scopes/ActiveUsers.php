<?php

declare(strict_types=1);

namespace Nova\Users\Models\Scopes;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\User;

class ActiveUsers implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('user', function (Builder $query): void {
            /** @var UserBuilder<User> $query */
            $query->active();
        });
    }
}
