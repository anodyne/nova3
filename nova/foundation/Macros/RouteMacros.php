<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Illuminate\Routing\Route;
use Nova\Pages\Models\Page;

/** @mixin Route */
class RouteMacros
{
    public function findPageFromRoute(): Closure
    {
        /** @this Route */
        return fn () => Page::key($this->getName())->first();
    }
}
