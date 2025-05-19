<?php

declare(strict_types=1);

namespace Nova\Onboarding\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Onboarding\Concerns\GetActiveOnboardingsForCurrentUser;

#[On('refresh-onboarding')]
class OnboardingOverview extends Component
{
    use GetActiveOnboardingsForCurrentUser;

    public function render(): View
    {
        return view('pages.onboarding.livewire.onboarding-overview', [
            'activeOnboardings' => $this->getActiveOnboardingsForCurrentUser(sync: true),
        ]);
    }
}
