<?php

namespace Nova\Themes\Actions;

use Nova\Foundation\Action;
use Nova\Themes\Models\Theme;
use Illuminate\Support\Facades\Artisan;
use Nova\Themes\DataTransferObjects\ThemeData;

class CreateTheme extends Action
{
    public $errorMessage = 'There was a problem creating the theme';

    public function execute(ThemeData $data): Theme
    {
        return $this->call(function () use ($data) {
            $theme = Theme::create(
                $data->except('variants')->toArray()
            );

            Artisan::call('nova:make-theme', [
                'name' => $theme->name,
                '--location' => $theme->location,
                '--variants' => $data->variants,
            ]);

            return $theme->refresh();
        });
    }
}
