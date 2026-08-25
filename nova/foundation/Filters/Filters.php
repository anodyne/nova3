<?php

declare(strict_types=1);

namespace Nova\Foundation\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/** @template TModel of Model */
abstract class Filters
{
    /** @var Builder<TModel> */
    protected Builder $builder;

    /** @var list<string> */
    protected array $filters = [];

    /**
     * Create a new filters instance.
     */
    public function __construct(protected Request $request) {}

    /**
     * Apply the filters.
     *
     * @param  Builder<TModel>  $builder
     * @return Builder<TModel>
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array<string, mixed>
     */
    public function getFilters(): array
    {
        return array_filter($this->request->only($this->filters));
    }
}
