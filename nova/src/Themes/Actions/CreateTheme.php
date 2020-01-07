<?php

namespace Nova\Themes\Actions;

use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Artisan;
use Nova\Themes\DataTransferObjects\ThemeData;

class CreateTheme
{
    public function execute(ThemeData $data)
    {
        $theme = Theme::create($data->toArray());

        Artisan::call('nova:make:theme', [
            'name' => $theme->name,
            '--location' => $theme->location,
        ]);

        return $theme;
    }
}
