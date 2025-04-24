<?php

declare(strict_types=1);

namespace Nova\Onboarding\Enums;

use Nova\Onboarding\Onboarding;

enum OnboardingProcess: string
{
    case FreshInstall = 'fresh-install';

    case NewUser = 'new-user';

    case NovaMigration = 'nova-migration';

    public function make(): Onboarding\OnboardingWizard
    {
        return match ($this) {
            self::FreshInstall => new Onboarding\FreshInstallOnboarding,
            self::NewUser => new Onboarding\NewUserOnboarding,
            self::NovaMigration => new Onboarding\NovaMigrationOnboarding,
        };
    }
}
