<?php

declare(strict_types=1);

use Nova\Onboarding\Actions\FinishOnboarding;
use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;

use function Pest\Laravel\assertDatabaseHas;

uses()->group('onboarding');

beforeEach(function () {
    $this->user = createUser();

    $this->onboarding = StartOnboarding::run(OnboardingProcess::NewUser, $this->user);
});

it('can finish an onboarding process for a user', function () {
    FinishOnboarding::run($this->onboarding);

    assertDatabaseHas(Onboarding::class, [
        'process' => OnboardingProcess::NewUser->value,
        'user_id' => $this->user->id,
        'completed_at' => now(),
    ]);
});
