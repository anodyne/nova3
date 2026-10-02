<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Arr;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Actions\Action;

class UpdateAddon extends Action
{
    public function handle(Addon $addon, AddonData $data): Addon
    {
        $addon->update(Arr::except($data->toArray(), 'settings'));

        BustActiveAddonsCache::run();

        return $addon->refresh();
    }
}
