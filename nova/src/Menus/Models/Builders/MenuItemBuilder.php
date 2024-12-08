<?php

declare(strict_types=1);

namespace Nova\Menus\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Menus\Enums\MenuStatus;

class MenuItemBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('status', MenuStatus::Active);
    }

    public function inactive(): self
    {
        return $this->where('status', MenuStatus::Inactive);
    }

    public function public(): self
    {
        return $this->whereRelation('menu', 'key', '=', 'public');
    }

    public function searchFor($search): self
    {
        return $this->where('label', 'like', "%{$search}%");
    }
}
