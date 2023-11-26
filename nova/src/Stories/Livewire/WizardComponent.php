<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Exception;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use Nova\Stories\Livewire\Steps\WizardStep;
use Spatie\LivewireWizard\Exceptions\InvalidStepComponent;

abstract class WizardComponent extends Component
{
    public ?string $currentStepName = null;

    public ?string $initialStep = null;

    #[On('previousStep')]
    public function previousStep(array $currentStepState)
    {
        $previousStep = collect($this->stepNames())
            ->before(fn (string $step) => $step === $this->currentStepName);

        // if (! $previousStep) {
        //     throw NoPreviousStep::make(self::class, $this->currentStepName);
        // }

        $this->showStep($previousStep, $currentStepState);
    }

    #[On('nextStep')]
    public function nextStep(array $currentStepState)
    {
        $nextStep = collect($this->stepNames())
            ->after(fn (string $step) => $step === $this->currentStepName);

        // if (! $nextStep) {
        //     throw NoNextStep::make(self::class, $this->currentStepName);
        // }

        $this->showStep($nextStep, $currentStepState);
    }

    #[On('showStep')]
    public function showStep($toStepName, array $currentStepState = [])
    {
        if ($this->currentStepName) {
            $this->setStepState($this->currentStepName, $currentStepState);
        }

        $this->currentStepName = $toStepName;
    }

    #[Computed]
    public function stepNames(): Collection
    {
        $steps = collect($this->steps())
            // ->each(function (string $stepClassName) {
            //     if (! is_a($stepClassName, WizardStep::class, true)) {
            //         throw InvalidStepComponent::doesNotExtendStepComponent(static::class, $stepClassName);
            //     }
            // })
            ->map(function (string $stepClassName) {
                $alias = app(ComponentRegistry::class)->getName($stepClassName);

                if (is_null($alias)) {
                    throw new Exception("{$alias} component is not registered with Livewire.");
                }

                return $alias;
            });

        if ($steps->isEmpty()) {
            throw new Exception('No steps returned');
        }

        return $steps;
    }
}
