<?php

declare(strict_types=1);

namespace Nova\Themes\Actions;

use Illuminate\Support\Facades\Artisan;
use Nova\Themes\DataTransferObjects\ThemeData;

class SetupThemeDirectory
{
    public function execute(ThemeData $data): void
    {
        Artisan::call('nova:make-theme', [
            'name' => $data->name,
            '--location' => $data->location,
            '--preview' => $data->preview,
            '--variants' => $data->variants,
        ]);
    }
}
