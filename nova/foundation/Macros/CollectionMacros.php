<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CollectionMacros
{
    public function active(): Closure
    {
        return function () {
            /** @var Collection $collection */
            $collection = $this;

            return $collection->filter(fn (mixed $model) => $model->deleted_at === null);
        };
    }

    public function paginate(): Closure
    {
        return function ($perPage = 15, $page = null, $options = []) {
            /** @var Collection $collection */
            $collection = $this;

            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

            if (! isset($options['page'])) {
                $options['path'] = '/'.request()->path();
            }

            return new LengthAwarePaginator(
                array_values($collection->forPage($page, $perPage)->toArray()),
                $collection->count(),
                $perPage,
                $page,
                $options
            );
        };
    }

    public function trashed(): Closure
    {
        return function () {
            /** @var Collection $collection */
            $collection = $this;

            return $collection->filter(fn (mixed $model) => $model->deleted_at !== null);
        };
    }
}
