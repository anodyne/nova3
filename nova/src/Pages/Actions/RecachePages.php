<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Pages\Models\Page;

class RecachePages
{
    use AsAction;

    public function handle(): void
    {
        Cache::rememberForever(CacheKeys::BasicPages->value, fn () => Page::query()->basic()->active()->get());

        Cache::rememberForever(CacheKeys::AdvancedPages->value, fn () => Page::query()->advanced()->get());
    }
}
