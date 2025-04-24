<?php

declare(strict_types=1);

namespace Nova\Onboarding\Livewire;

use Livewire\Component;
use Nova\Onboarding\Onboarding\NewUserOnboarding as NewUserOnboardingWizard;
use Nova\Onboarding\Onboarding\OnboardingWizard;

class NewUserOnboarding extends Component
{
    public OnboardingWizard $process;

    public function mount()
    {
        $this->process = new NewUserOnboardingWizard;
    }

    public function render()
    {
        return view('pages.onboarding.livewire.onboarding-new-user');
    }
}
