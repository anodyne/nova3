<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
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
        $this->authorize('update', $settings = settings());

        return $settingsManager->get($tab)->response::sendWith([
            'settings' => $settings,
            'systemNotifications' => SystemNotification::get(),
            'tab' => $tab,
            'themes' => Theme::active()->orderBy('name')->get(),
        ]);
    }

    public function update(
        Request $request,
        SettingsManager $settingsManager,
        $tab = 'general'
    ) {
        $this->authorize('update', settings());

        try {
            $tabString = str($tab)->replace('-', ' ');

            $info = $settingsManager->get($tab);

            UpdateSettings::run(
                $tabString->snake(),
                $data = $info->dto::from($request)
            );

            if ($info->action !== null) {
                $info->action::run($data);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage(), $th->getTrace());
        }

        return redirect()
            ->route('settings.index', $tab)
            ->withToast("{$tabString->ucfirst()} settings have been updated.");
    }
}
