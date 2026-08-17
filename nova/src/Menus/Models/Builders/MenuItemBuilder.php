<?php

declare(strict_types=1);

namespace Nova\Menus\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Menus\Models\MenuItem;

/**
 * @template TModel of MenuItem
 *
 * @extends Builder<TModel>
 */
class MenuItemBuilder extends Builder
{
    use QueriesStatus;

    public function public(): self
    {
        return $this->whereRelation('menu', 'key', '=', 'public');
    }

    public function searchFor($search): self
    {
        return $this->where('label', 'like', "%{$search}%");
    }
}
