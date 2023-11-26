<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire\Concerns;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use Livewire\Livewire;

trait InteractsWithRoute
{
    public function getCurrentRoute(): Route
    {
        $request = Request::create(Livewire::originalUrl(), Livewire::originalMethod());

        return app('router')->getRoutes()->match($request);
    }
}
