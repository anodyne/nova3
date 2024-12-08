<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Models\Addon;

class DeleteAddon
{
    use AsAction;

    public function handle(Addon $addon): Addon
    {
        $addon->runScript('uninstall');

        $addon = tap($addon)->delete();

        BustActiveAddonsCache::run();

        return $addon;
    }
}
