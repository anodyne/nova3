<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Menus\Models\Menu;

class RecacheMenus
{
    use AsAction;

    public function handle(): void
    {
        Cache::rememberForever(CacheKeys::BasicMenu->value, function () {
            return Menu::public()
                ->with([
                    'items' => fn (HasMany $query): HasMany => $query->where('status', BasicStatus::Active),
                    'items.page',
                    'items.items',
                ])
                ->first();
        });
    }
}
