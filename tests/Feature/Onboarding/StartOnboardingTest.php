<?php

declare(strict_types=1);

use Nova\Onboarding\Actions\StartOnboarding;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;

use function Pest\Laravel\assertDatabaseHas;

uses()->group('onboarding');

it('can start an onboarding process for a user', function () {
    $user = createUser();

    StartOnboarding::run(OnboardingProcess::NewUser, $user);

    assertDatabaseHas(Onboarding::class, [
        'process' => OnboardingProcess::NewUser->value,
        'user_id' => $user->id,
    ]);
});
