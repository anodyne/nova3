<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\Request;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Foundation\Controllers\Controller;
use Nova\Settings\Actions\UpdateApplicationReviewers;
use Nova\Settings\Actions\UpdateSettings;
use Nova\Settings\Data\ApplicationReviewers;
use Nova\Settings\Data\Applications;
use Nova\Settings\Responses\ApplicationSettingsResponse;

class ApplicationSettingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        $this->authorize('update', $settings = settings());

        return ApplicationSettingsResponse::sendWith([
            'usersWithApprovePermissionsCount' => ApplicationReviewer::globalReviewersWithApprovalPermission()->count(),
            'settings' => $settings->applications,
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', settings());

        UpdateSettings::run('applications', Applications::from($request));

        UpdateApplicationReviewers::run(ApplicationReviewers::from($request));

        return redirect()
            ->route('admin.settings.applications.edit')
            ->notify('Applications settings have been updated');
    }
}
