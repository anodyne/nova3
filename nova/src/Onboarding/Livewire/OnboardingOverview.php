<?php

declare(strict_types=1);

namespace Nova\Onboarding\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Onboarding\Models\Onboarding;

class OnboardingOverview extends Component
{
    public string $selected = 'new-user';

    #[Computed]
    public function activeOnboardings(): Collection
    {
        return Onboarding::query()
            ->user(Auth::user())
            ->incomplete()
            ->get();
    }

    #[Computed]
    public function onboardingComponent(): string
    {
        return "onboarding-{$this->selected}";
    }

    #[Computed]
    public function selectedOnboarding(): Onboarding
    {
        return Onboarding::where('key', $this->selected)->first();
    }

    public function render()
    {
        return view('pages.onboarding.livewire.onboarding-overview', [
            'activeOnboardings' => $this->activeOnboardings,
            'onboardingComponent' => $this->onboardingComponent,
            'selectedOnboarding' => $this->selectedOnboarding,
        ]);
    }
}
