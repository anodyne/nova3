<?php

declare(strict_types=1);

namespace Nova\Posts\Exceptions;

use Exception;

class InvalidStepComponent extends Exception
{
    public static function doesNotExtendWizardStepComponent(
        string $wizardComponentClassName,
        string $invalidStepComponentName
    ): self {
        return new self("The `steps` function of component `{$wizardComponentClassName}` returned an invalid step component `{$invalidStepComponentName}`. A valid step component should extend `WizardStep`.");
    }

    public static function notRegisteredWithLivewire(
        string $wizardComponentClassName,
        string $invalidStepComponentName
    ): self {
        return new self("The `steps` function of component `{$wizardComponentClassName}` returned step component `{$invalidStepComponentName}` that was not registered with Livewire.");
    }
}
