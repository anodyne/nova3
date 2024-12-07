<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Addons\Data\AddonRepository;
use Nova\Settings\Data\FontFamilies;
use Nova\Setup\Randomize;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Data\ThemeSettings;
use Nova\Themes\Enums\ThemeStatus;
use Nova\Themes\Events\ThemeInstalled;
use Nova\Themes\Models\Theme;

class InstallTheme
{
    use AsAction;

    public function handle(string $path): Theme
    {
        $data = json_decode(Storage::disk('themes')->get("{$path}/theme.json"), true);

        $settings = new ThemeSettings(
            fonts: FontFamilies::from(data_get($data, 'settings.fonts', [
                'headerProvider' => 'local',
                'headerFamily' => Randomize::publicHeaderFont(),
                'bodyProvider' => 'local',
                'bodyFamily' => Randomize::publicBodyFont(),
            ])),
            settings: data_get($data, 'settings.settings', [])
        );

        $data = new ThemeData(
            name: data_get($data, 'name'),
            location: data_get($data, 'location'),
            version: data_get($data, 'version'),
            credits: data_get($data, 'credits'),
            status: ThemeStatus::Active,
            preview: data_get($data, 'preview'),
            settings: $settings,
            repository: AddonRepository::from(data_get($data, 'repository')),
        );

        $theme = CreateTheme::run($data);

        ThemeInstalled::dispatch($theme);

        return $theme;
    }
}
