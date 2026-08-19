<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Media\Actions\UploadImage;
use Nova\Media\Enums\ImageAction;
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

    public function edit(): Responsable
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

        DB::transaction(function () use ($request): void {
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

            UploadImage::run(
                model: settings(),
                collection: 'logo-full',
                action: $this->getImageAction($request, 'logo_full'),
                tempPath: $this->getImageTempPath($request, 'logo_full')
            );

            UploadImage::run(
                model: settings(),
                collection: 'logo-sidebar-light',
                action: $this->getImageAction($request, 'logo_sidebar_light'),
                tempPath: $this->getImageTempPath($request, 'logo_sidebar_light')
            );

            UploadImage::run(
                model: settings(),
                collection: 'logo-sidebar-dark',
                action: $this->getImageAction($request, 'logo_sidebar_dark'),
                tempPath: $this->getImageTempPath($request, 'logo_sidebar_dark')
            );
        });

        return back()->notify('Appearance settings have been updated');
    }

    protected function getImageAction(Request $request, string $key): ImageAction
    {
        return $request->enum("{$key}_action", ImageAction::class) ?? ImageAction::Unchanged;
    }

    protected function getImageTempPath(Request $request, string $key): ?string
    {
        return $request->string("{$key}_temp_path")->toString() ?: null;
    }
}
