<?php

namespace Nova\Foundation\Concerns;

use Illuminate\Contracts\Auth\Access\Gate;

trait CanAuthorizeAny
{
    /**
     * Determine if the entity has any of the given abilities.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     *
     * @return bool
     */
    public function hasAny($ability, $arguments = [])
    {
        return app(Gate::class)->forUser($this)->any($ability, $arguments);
    }
}
