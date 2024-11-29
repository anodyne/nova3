<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Models\Addon;

class UpdateAddon
{
    use AsAction;

    public function handle(Addon $addon, AddonData $data): Addon
    {
        $addon->update($data->except('settings')->all());

        BustActiveAddonsCache::run();

        return $addon->refresh();
    }
}
