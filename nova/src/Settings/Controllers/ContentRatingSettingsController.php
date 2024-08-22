<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\ContentRatings;
use Nova\Settings\Responses\ContentRatingSettingsResponse;

class ContentRatingSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return ContentRatingSettingsResponse::sendWith([
            'settings' => $settings->ratings,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('ratings', $data = ContentRatings::from($request));

        return redirect()
            ->route('admin.settings.content-ratings.edit')
            ->notify('Content rating settings have been updated');
    }
}
