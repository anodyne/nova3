<?php

declare(strict_types=1);

namespace Nova\Onboarding\Responses;

use Nova\Foundation\Responses\Responsable;

class OnboardingOverviewResponse extends Responsable
{
    public string $view = 'onboarding.index';
}
