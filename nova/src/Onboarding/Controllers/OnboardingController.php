<?php

declare(strict_types=1);

namespace Nova\Onboarding\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Onboarding\Responses\OnboardingOverviewResponse;

class OnboardingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return OnboardingOverviewResponse::send();
    }
}
