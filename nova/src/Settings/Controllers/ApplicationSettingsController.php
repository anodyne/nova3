<?php

declare(strict_types=1);

namespace Nova\Settings\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
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

    public function edit(): Responsable
    {
        $this->authorize('update', $settings = settings());

        return ApplicationSettingsResponse::sendWith([
            'usersWithApprovePermissionsCount' => ApplicationReviewer::globalReviewersWithApprovalPermission()->count(),
            'settings' => $settings->applications,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorize('update', settings());

        DB::transaction(function () use ($request): void {
            UpdateSettings::run('applications', Applications::from($request));

            UpdateApplicationReviewers::run(ApplicationReviewers::from($request));
        });

        return back()->notify('Applications settings have been updated');
    }
}
