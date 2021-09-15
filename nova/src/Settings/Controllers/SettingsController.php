<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Responses\DiscordSettingsResponse;
use Nova\Settings\Responses\GeneralSettingsResponse;
use Nova\Settings\Responses\PostingActivitySettingsResponse;
use Nova\Settings\Values\Characters;
use Nova\Settings\Values\Discord;
use Nova\Settings\Values\PostingActivity;
use Nova\Themes\Models\Theme;

class SettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index($tab = 'general')
    {
        $response = match ($tab) {
            default => GeneralSettingsResponse::class,
            'discord' => DiscordSettingsResponse::class,
            'posting-activity' => PostingActivitySettingsResponse::class,
        };

        return app($response)->with([
            'settings' => app('nova.settings'),
            'tab' => $tab,
            'themes' => Theme::whereActive()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, $tab = 'general')
    {
        $this->authorize('update', app('nova.settings'));

        $data = match ($tab) {
            default => 'general',
            'characters' => Characters::fromRequest($request),
            'discord' => Discord::fromRequest($request),
            'posting-activity' => PostingActivity::fromRequest($request),
        };

        $tabString = Str::of($tab)->replace('-', ' ');

        UpdateSettings::run($tabString->snake(), $data);

        return redirect()
            ->route('settings.index', $tab)
            ->withToast("{$tabString->ucfirst()} settings have been updated.");
    }
}
