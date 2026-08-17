<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/** @mixin Collection */
class CollectionMacros
{
    public function active(): Closure
    {
        /** @this Collection */
        return function () {
            return $this->filter(fn (mixed $model) => $model->deleted_at === null);
        };
    }

    public function paginate(): Closure
    {
        /** @this Collection */
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

    public function trashed(): Closure
    {
        /** @this Collection */
        return function () {
            return $this->filter(fn (mixed $model) => $model->deleted_at !== null);
        };
    }
}
