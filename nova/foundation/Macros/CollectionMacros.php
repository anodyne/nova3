<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CollectionMacros
{
    public function paginate()
    {
        return function ($perPage = 15, $page = null, $options = []) {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

            if (! isset($options['page'])) {
                $options['path'] = '/'.request()->path();
            }

            return new LengthAwarePaginator(
                array_values($this->forPage($page, $perPage)->toArray()),
                $this->count(),
                $perPage,
                $page,
                $options
            );
        };
    }
}
