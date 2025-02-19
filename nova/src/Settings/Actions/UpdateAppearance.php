<?php

declare(strict_types=1);

namespace Nova\Settings\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Models\Settings;

class UpdateAppearance
{
    use AsAction;

    public function handle(Appearance $data, Request $request): Settings
    {
        if ($data->imagePath !== null) {
            settings()->addMedia($data->imagePath)->toMediaCollection('logo');

            activity()
                ->performedOn(settings())
                ->event('uploaded image')
                ->log('uploaded image');
        }

        return settings()->refresh();
    }
}
