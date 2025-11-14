<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Menus\Models\Menu;

class RecacheMenus
{
    use AsAction;

    public function handle(): void
    {
        Cache::rememberForever(CacheKeys::BasicMenu->value, function () {
            return Menu::query()
                ->with([
                    'items' => fn (Builder $query): Builder => $query->active(),
                    'items.page',
                    'items.items',
                ])
                ->public()
                ->first();
        });
    }
}
