<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\Enums\CacheKeys;

class BustPagesCache extends Action
{
    public function handle(): void
    {
        Cache::forget(CacheKeys::BasicPages->value);
        Cache::forget(CacheKeys::AdvancedPages->value);
    }
}
