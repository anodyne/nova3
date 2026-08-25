<?php

declare(strict_types=1);

namespace Nova\Onboarding\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Onboarding\Actions\FinishOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;
use Nova\Onboarding\Onboarding\OnboardingChecklist;

/**
 * @property-read OnboardingChecklist $onboarder
 * @property-read int $percentComplete
 * @property-read OnboardingProcess $process
 */
class OnboardingDetail extends Component
{
    /** @var array<string, bool> */
    public array $stepsData = [];

    #[Locked]
    public Onboarding $onboarding;

    public function finish(): void
    {
        FinishOnboarding::run($this->onboarding);

        $this->dispatch('refresh-onboarding');

        Notification::make()->success()
            ->title($this->onboarding->process->getNotificationTitle())
            ->send();
    }

    public function updatedStepsData(): void
    {
        $this->onboarding->update(['steps' => $this->stepsData]);
    }

    public function mount(): void
    {
        $this->stepsData = $this->onboarding->steps ?? [];
    }

    public function render(): View
    {
        return view('pages.onboarding.livewire.onboarding-detail', [
            'onboarder' => $this->onboarder,
            'percentComplete' => $this->percentComplete,
            'process' => $this->process,
        ]);
    }

    #[Computed]
    public function onboarder(): OnboardingChecklist
    {
        return $this->onboarding->process->make($this->onboarding);
    }

    #[Computed]
    public function percentComplete(): int
    {
        return $this->onboarder->percentComplete();
    }

    #[Computed]
    public function process(): OnboardingProcess
    {
        return $this->onboarding->process;
    }
}
