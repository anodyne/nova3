<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Support\Facades\Cache;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\Enums\CacheKeys;

class BustMenusCache extends Action
{
    public function handle(): void
    {
        Cache::forget(CacheKeys::BasicMenu->value);
    }
}
