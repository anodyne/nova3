<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Responses\PostingActivitySettingsResponse;

class PostingActivitySettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return PostingActivitySettingsResponse::sendWith([
            'settings' => $settings->posting_activity,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('posting_activity', PostingActivity::from($request));

        return redirect()
            ->route('admin.settings.posting-activity.edit')
            ->notify('Posting activity settings have been updated');
    }
}
