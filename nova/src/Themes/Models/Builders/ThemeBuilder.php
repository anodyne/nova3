<?php

declare(strict_types=1);

namespace Nova\Themes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Themes\Models\Theme;

/**
 * @extends Builder<Theme>
 */
class ThemeBuilder extends Builder
{
    use QueriesStatus;

    public function location(string $location): self
    {
        return $this->where('location', $location);
    }
}
