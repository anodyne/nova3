<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Models\Addon;

class CreateAddon
{
    use AsAction;

    public function handle(AddonData $data): Addon
    {
        return Addon::create($data->all());
    }
}
