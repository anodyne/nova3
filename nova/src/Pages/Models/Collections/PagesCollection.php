<?php

declare(strict_types=1);

namespace Nova\Pages\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Pages\Models\Page;

/**
 * @extends Collection<int|string, Page>
 */
class PagesCollection extends Collection
{
    public function advanced(): static
    {
        return $this->filter(
            fn (Page $page): bool => $page->resource !== null
        );
    }

    public function basic(): static
    {
        return $this
            ->filter(fn (Page $page): bool => $page->resource === null)
            ->reject(fn (Page $page): bool => $page->status === BasicStatus::Inactive);
    }
}
