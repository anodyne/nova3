<?php

declare(strict_types=1);

namespace Nova\Addons\Actions;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonData;
use Nova\Addons\Data\AddonRepository;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Events\AddonInstalled;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\BasicStatus;

class InstallAddon
{
    use AsAction;

    public function handle(string $path): Addon
    {
        $jsonData = json_decode(Storage::disk('addons')->get("{$path}/addon.json"), true);

        $addonData = AddonData::from(
            name: data_get($jsonData, 'name'),
            location: data_get($jsonData, 'location'),
            version: data_get($jsonData, 'version'),
            credits: data_get($jsonData, 'credits'),
            status: BasicStatus::Inactive,
            type: AddonType::tryFrom(data_get($jsonData, 'type', 'extension')),
            preview: data_get($jsonData, 'preview'),
            settings: AddonSettings::from(settings: []),
            repository: data_get($jsonData, 'repository') ? AddonRepository::from(data_get($jsonData, 'repository')) : null,
        );

        $addon = activity()->withoutLogs(fn (): Addon => CreateAddon::run($addonData));

        AddonInstalled::dispatch($addon);

        activity()
            ->performedOn($addon)
            ->event('installed')
            ->log('installed');

        return $addon;
    }
}
