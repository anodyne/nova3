<?php

declare(strict_types=1);

namespace Nova\Users\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Users\Models\States\Status\Active;

/** @implements Scope<ApplicationReviewer> */
class ActiveUsers implements Scope
{
    /**
     * @param  Builder<covariant ApplicationReviewer>  $builder
     * @param  ApplicationReviewer  $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('user', function (Builder $query): void {
            $query->whereState('status', Active::class);
        });
    }
}
