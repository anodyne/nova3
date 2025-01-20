<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;

class DeleteAddon
{
    use AsAction;

    public function handle(Addon $addon): Addon
    {
        return DB::transaction(function () use ($addon) {
            $addon->runScript('uninstall');

            $addon = tap($addon)->delete();

            BustActiveAddonsCache::run();

            return $addon;
        });
    }
}
