<?php

declare(strict_types=1);

namespace Nova\Pages\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PageBuilder extends Builder
{
    public function key($key): self
    {
        return $this->where('key', $key);
    }
}
