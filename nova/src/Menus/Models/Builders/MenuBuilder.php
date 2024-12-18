<?php

declare(strict_types=1);

namespace Nova\Menus\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class MenuBuilder extends Builder
{
    public function public(): self
    {
        return $this->where('key', 'public');
    }

    public function searchFor($search): self
    {
        return $this->where('label', 'like', "%{$search}%");
    }
}
