<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateAppearance;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\Appearance;
use Nova\Settings\Responses\AppearanceSettingsResponse;
use Nova\Themes\Models\Theme;

class AppearanceSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return AppearanceSettingsResponse::sendWith([
            'settings' => $settings->appearance,
            'themes' => Theme::active()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        DB::transaction(function () use ($request) {
            $settings = settings('appearance');

            $requestWithColors = $request->merge([
                'colors_primary' => $settings->colorsPrimary,
                'colors_danger' => $settings->colorsDanger,
                'colors_info' => $settings->colorsInfo,
                'colors_success' => $settings->colorsSuccess,
                'colors_warning' => $settings->colorsWarning,
                'colors_gray' => $settings->colorsGray,
            ]);

            UpdateSettings::run('appearance', $data = Appearance::from($requestWithColors));

            UpdateAppearance::run($data, $request);
        });

        return back()->notify('Appearance settings have been updated');
    }
}
