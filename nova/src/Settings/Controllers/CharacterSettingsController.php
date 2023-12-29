<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Characters;
use Nova\Settings\Responses\CharacterSettingsResponse;

class CharacterSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return CharacterSettingsResponse::sendWith([
            'settings' => $settings->characters,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('characters', Characters::from($request));

        return redirect()
            ->route('settings.characters.edit')
            ->notify('Character settings have been updated');
    }
}
