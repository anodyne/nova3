<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

class FiltersManager
{
    /** @var list<string> */
    protected array $globalFilters = [];

    /** @var array<string, list<string>> */
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

    /** @return list<string> */
    public function resolveFiltersFor(?string $route): array
    {
        return array_merge(
            $this->globalFilters,
            $route !== null ? ($this->routeFilters[$route] ?? []) : []
        );
    }
}
