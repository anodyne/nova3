<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\CacheKeys;

class BustActiveAddonsCache
{
    use AsAction;

    public function handle(): void
    {
        Cache::forget(CacheKeys::Addons->value);

        Cache::rememberForever(CacheKeys::Addons->value, function (): array {
            $activeAddons = Addon::active()->get();

            return $activeAddons
                ->mapToGroups(fn (Addon $addon): array => [$addon->type->value => $addon->location])
                ->map(fn ($group): array => $group->all())
                ->all();
        });
    }
}
