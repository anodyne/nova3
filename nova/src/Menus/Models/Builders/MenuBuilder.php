<?php

declare(strict_types=1);

namespace Nova\Menus\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Menus\Models\Menu;

/**
 * @extends Builder<Menu>
 */
class MenuBuilder extends Builder
{
    use QueriesStatus;

    public function public(): self
    {
        return $this->where('key', 'public');
    }
}
