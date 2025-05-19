<?php

declare(strict_types=1);

namespace Nova\Onboarding\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Nova\Onboarding\Models\Onboarding as OnboardingModel;
use Nova\Onboarding\Onboarding;

enum OnboardingProcess: string implements HasDescription, HasLabel
{
    case FreshInstall = 'fresh-install';

    case NewUser = 'new-user';

    case NovaMigration = 'nova-migration';

    public function getCallToActionDescription(): ?string
    {
        return match ($this) {
            self::FreshInstall => 'Configure Nova for your game and players for the best experience',
            self::NewUser => 'Let’s make sure your account is setup and ready to use',
            self::NovaMigration => 'Configure Nova for your game and players for the best experience and verify that the migration worked as expected',
            default => $this->getDescription(),
        };
    }

    public function getCallToActionLabel(): ?string
    {
        return match ($this) {
            default => 'Get started with Nova',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::FreshInstall => 'Configure Nova for your game and players for the best experience',
            self::NewUser => 'Make sure your account is configured and ready to use',
            self::NovaMigration => 'Configure Nova for your game and players for the best experience and verify that the migration worked as expected',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FreshInstall => 'Finalize Nova setup',
            self::NewUser => 'Setup your account',
            self::NovaMigration => 'Finalize migrating from Nova 2',
        };
    }

    public function getNotificationTitle(): ?string
    {
        return match ($this) {
            self::FreshInstall => 'Nova setup has been finalized',
            self::NewUser => 'Your account has been successfully setup',
            self::NovaMigration => 'Nova setup has been finalized',
        };
    }

    public function make(OnboardingModel $model): Onboarding\OnboardingChecklist
    {
        return match ($this) {
            self::FreshInstall => new Onboarding\FreshInstall\FreshInstallOnboarding($model),
            self::NewUser => new Onboarding\NewUser\NewUserOnboarding($model),
            self::NovaMigration => new Onboarding\NovaMigration\NovaMigrationOnboarding($model),
        };
    }
}
