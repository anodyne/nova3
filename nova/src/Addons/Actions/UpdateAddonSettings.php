<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Actions\Action;

class UpdateAddonSettings extends Action
{
    public function handle(Addon $addon, AddonSettings $data): Addon
    {
        $addon->update(['settings' => $data]);

        return $addon->refresh();
    }
}
