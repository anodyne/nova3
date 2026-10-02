<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Actions\Action;

class DeleteAddon extends Action
{
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
