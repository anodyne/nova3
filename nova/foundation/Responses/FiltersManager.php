<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

class FiltersManager
{
    protected array $globalFilters = [];

    protected array $routeFilters = [];

    public function registerGlobalFilter(string $concrete): self
    {
        $this->globalFilters[] = $concrete;

        return $this;
    }

    public function registerRouteFilter(string $route, string $concrete): self
    {
        $this->routeFilters[$route][] = $concrete;

        return $this;
    }

    public function resolveFiltersFor(string $route): array
    {
        return array_merge(
            $this->globalFilters,
            data_get($this->routeFilters, $route, [])
        );
    }
}
