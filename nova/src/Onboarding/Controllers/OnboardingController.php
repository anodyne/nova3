<?php

declare(strict_types=1);

namespace Nova\Onboarding\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Onboarding\Responses\OnboardingOverviewResponse;

class OnboardingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        return OnboardingOverviewResponse::send();
    }
}
