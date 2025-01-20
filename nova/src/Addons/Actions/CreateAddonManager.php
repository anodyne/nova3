<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;
use Nova\Addons\Requests\StoreAddonRequest;

class CreateAddonManager
{
    use AsAction;

    public function handle(StoreAddonRequest $request): Addon
    {
        return DB::transaction(function () use ($request) {
            $addon = CreateAddon::run($request->getAddonData());

            SetupAddonDirectory::run($request->getAddonData());

            BustActiveAddonsCache::run();

            return $addon;
        });
    }
}
