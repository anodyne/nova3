<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Nova\Addons\Data\AddonData;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Actions\Action;

class CreateAddon extends Action
{
    public function handle(AddonData $data): Addon
    {
        return Addon::create($data->toArray());
    }
}
