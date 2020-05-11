<?php

namespace Nova\Foundation;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Locator
{
    protected $paths = [];

    // locate()->page('dashboard')
    // locate()->layout('app-sidebar')
    // locate()->template('simple')
    // locate()->structure('app-server')

    public function __call($method, $parameters)
    {
        return $this->buildLocationMap($parameters[0], Str::plural($method));
    }

    protected function buildLocationMap($view, $directory): Collection
    {
        return collect($this->paths)
            ->map(function ($path) use ($view, $directory) {
                return join('.', [
                    $path,
                    $directory,
                    $view
                ]);
            });
    }
}
