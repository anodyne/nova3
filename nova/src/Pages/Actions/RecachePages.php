<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Pages\Models\Page;

class RecachePages
{
    use AsAction;

    public function handle(): void
    {
        Cache::rememberForever('nova.basic-pages', fn () => Page::query()->basic()->active()->get());

        Cache::rememberForever('nova.advanced-pages', fn () => Page::query()->advanced()->get());
    }
}
