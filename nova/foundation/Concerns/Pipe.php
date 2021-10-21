<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Closure;

interface Pipe
{
    public function handle($content, Closure $next);
}
