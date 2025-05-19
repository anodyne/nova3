<?php

declare(strict_types=1);

use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;

use function Pest\Laravel\assertDatabaseHas;

it('can start an onboarding process for a user', function () {
    $user = createUser();

    StartOnboarding::run(OnboardingProcess::NewUser, $user);

    assertDatabaseHas('onboarding_user', [
        'onboarding_id' => 2,
        'user_id' => $user->id,
    ]);
});
