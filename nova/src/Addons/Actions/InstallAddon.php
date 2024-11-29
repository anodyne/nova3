<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Data\AddonRepository;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonStatus;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Events\AddonInstalled;
use Nova\Addons\Models\Addon;

class InstallAddon
{
    use AsAction;

    public function handle(string $path): Addon
    {
        $data = json_decode(Storage::disk('addons')->get("{$path}/addon.json"), true);

        $data = new AddonData(
            name: data_get($data, 'name'),
            location: data_get($data, 'location'),
            version: data_get($data, 'version'),
            credits: data_get($data, 'credits'),
            status: AddonStatus::Inactive,
            type: AddonType::tryFrom(data_get($data, 'type', 'extension')),
            preview: data_get($data, 'preview'),
            settings: new AddonSettings(
                settings: []
            ),
            repository: AddonRepository::from(data_get($data, 'repository')),
        );

        $addon = CreateAddon::run($data);

        AddonInstalled::dispatch($addon);

        return $addon;
    }
}
