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
        if (is_null($data->imagePath)) {
            settings()->clearMediaCollection('logo');

            activity()
                ->performedOn(settings())
                ->event('removed logo')
                ->log('removed logo');
        } else {
            settings()->addMedia($data->imagePath)->toMediaCollection('logo');

            activity()
                ->performedOn(settings())
                ->event('uploaded logo')
                ->log('uploaded logo');
        }

        return settings()->refresh();
    }
}
