<?php

declare(strict_types=1);

namespace Nova\Discussions\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Discussions\Models\Discussion;

trait Discussable
{
    public function discussion(): MorphOne
    {
        return $this->morphOne(Discussion::class, 'discussable');
    }
}
