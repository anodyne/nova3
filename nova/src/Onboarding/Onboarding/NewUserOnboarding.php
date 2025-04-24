<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

use Livewire\Wireable;

class NewUserOnboarding implements OnboardingWizard, Wireable
{
    public function toLivewire()
    {
        return [];
    }

    public function steps(): array
    {
        return [
            new Steps\UpdateTimezone,
        ];
    }

    public static function fromLivewire($value)
    {
        return new static;
    }
}
