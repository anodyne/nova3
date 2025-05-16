<?php

declare(strict_types=1);

namespace Nova\Onboarding\Providers;

use Nova\DomainServiceProvider;
use Nova\Onboarding\Livewire\OnboardingDetail;
use Nova\Onboarding\Livewire\OnboardingOverview;

class OnboardingServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'onboarding-detail' => OnboardingDetail::class,
            'onboarding-overview' => OnboardingOverview::class,
        ];
    }
}
