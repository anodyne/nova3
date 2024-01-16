<?php

declare(strict_types=1);

namespace Nova\Pages\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use Nova\Pages\Models\Page;

class PagesCollection extends Collection
{
    public function advanced()
    {
        return $this->filter(
            fn (Page $page): bool => $page->resource !== null
        );
    }

    public function basic()
    {
        return $this->filter(
            fn (Page $page): bool => $page->resource === null
        );
    }
}
