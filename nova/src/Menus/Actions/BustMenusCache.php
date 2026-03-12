<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\CacheKeys;

class BustMenusCache
{
    use AsAction;

    public function handle(): void
    {
        Cache::forget(CacheKeys::BasicMenu->value);
    }
}
