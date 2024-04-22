<?php

declare(strict_types=1);

namespace Nova\Pages\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PageBuilder extends Builder
{
    public function advanced(): self
    {
        return $this->whereNotNull('resource');
    }

    public function basic(): self
    {
        return $this->whereNull('resource');
    }

    public function key(string $key): self
    {
        return $this->where('key', $key);
    }

    public function searchFor(string $search): self
    {
        return $this->whereAny(['name', 'key', 'uri'], 'like', "%{$search}%");
    }
}
