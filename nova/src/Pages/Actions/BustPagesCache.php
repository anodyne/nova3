<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\CacheKeys;

class BustPagesCache
{
    use AsAction;

    public function handle(): void
    {
        Cache::forget(CacheKeys::BasicPages->value);
        Cache::forget(CacheKeys::AdvancedPages->value);
    }
}
