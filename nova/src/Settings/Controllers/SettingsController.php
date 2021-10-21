<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Models\SystemNotification;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\SettingsManager;
use Nova\Themes\Models\Theme;

class SettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index(SettingsManager $settingsManager, $tab = 'general')
    {
        $this->authorize('update', settings());

        // return app($settingsManager->get($tab)->response)->with([
        //     'settings' => settings(),
        //     'systemNotifications' => SystemNotification::get(),
        //     'tab' => $tab,
        //     'themes' => Theme::whereActive()->orderBy('name')->get(),
        // ]);
        return $settingsManager->get($tab)->response::sendWith([
            'settings' => settings(),
            'systemNotifications' => SystemNotification::get(),
            'tab' => $tab,
            'themes' => Theme::whereActive()->orderBy('name')->get(),
        ]);
    }

    public function update(
        Request $request,
        SettingsManager $settingsManager,
        $tab = 'general'
    ) {
        $this->authorize('update', settings());

        $tabString = Str::of($tab)->replace('-', ' ');

        UpdateSettings::run(
            $tabString->snake(),
            $settingsManager->get($tab)->dto::fromRequest($request)
        );

        return redirect()
            ->route('settings.index', $tab)
            ->withToast("{$tabString->ucfirst()} settings have been updated.");
    }
}
