<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Models\Addon;

class UpdateAddonSettings
{
    use AsAction;

    public function handle(Addon $addon, AddonSettings $data): Addon
    {
        $addon->update(['settings' => $data]);

        return $addon->refresh();
    }
}
