<?php

declare(strict_types=1);

namespace Nova\Onboarding\Providers;

use Nova\DomainServiceProvider;
use Nova\Onboarding\Livewire\NewUserOnboarding;
use Nova\Onboarding\Livewire\OnboardingOverview;

class OnboardingServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'onboarding-overview' => OnboardingOverview::class,
            'onboarding-new-user' => NewUserOnboarding::class,
        ];
    }
}
