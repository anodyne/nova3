<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

use Nova\Onboarding\Models\Onboarding;

abstract class OnboardingChecklist
{
    public function __construct(protected Onboarding $model) {}

    abstract public function steps(): array;

    public function getStepsData(): array
    {
        return collect($this->model->steps)
            ->flatMap(fn (OnboardingChecklistStep $step): array => [$step->key() => $step->completed()])
            ->toArray();
    }

    public function percentComplete(): int
    {
        $total = 0;
        $completed = 0;

        foreach ($this->steps() as $step) {
            $total += 1;

            if ($step->completed()) {
                $completed += 1;
            }
        }

        $percentage = round(($completed / $total) * 100, 0);

        return (int) min(100, $percentage);
    }

    public function syncSteps(): void
    {
        $newState = collect($this->steps())
            ->mapWithKeys(fn (OnboardingChecklistStep $step): array => [$step->key() => $step->completed()])
            ->toArray();

        if ($this->model->steps !== $newState) {
            $this->model->steps = $newState;
            $this->model->save();
        }
    }

    /**
     * @return array<\Nova\Onboarding\Onboarding\OnboardingChecklistStep>
     */
    protected function buildSteps(array $stepClasses): array
    {
        return array_map(
            fn ($class): OnboardingChecklistStep => new $class($this->model->steps),
            $stepClasses
        );
    }
}
