<?php

declare(strict_types=1);

namespace Nova\Themes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Themes\Models\Theme;

/**
 * @template TModel of Theme
 *
 * @extends Builder<TModel>
 */
class ThemeBuilder extends Builder
{
    use QueriesStatus;

    public function location($location): self
    {
        return $this->where('location', $location);
    }
}
