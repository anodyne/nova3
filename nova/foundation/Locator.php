<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Locator
{
    /** @var list<string> */
    protected array $paths = [];

    // locate()->page('dashboard')
    // locate()->layout('app-sidebar')
    // locate()->template('simple')
    // locate()->structure('app-server')

    /**
     * @param  list<mixed>  $parameters
     * @return Collection<int, non-falsy-string>
     */
    public function __call(string $method, array $parameters): Collection
    {
        return $this->buildLocationMap($parameters[0], Str::plural($method));
    }

    /** @return Collection<int, non-falsy-string> */
    protected function buildLocationMap(string $view, string $directory): Collection
    {
        return collect($this->paths)
            ->map(fn ($path): string => implode('.', [
                $path,
                $directory,
                $view,
            ]));
    }
}
