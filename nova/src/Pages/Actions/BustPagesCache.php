<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class BustPagesCache
{
    use AsAction;

    public function handle(): void
    {
        Cache::forget('nova.basic-pages');
        Cache::forget('nova.advanced-pages');
    }
}
