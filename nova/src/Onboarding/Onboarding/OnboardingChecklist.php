<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

use Nova\Onboarding\Models\Onboarding;

abstract class OnboardingChecklist
{
    public function __construct(protected Onboarding $model) {}

    /** @return list<OnboardingChecklistStep> */
    abstract public function steps(): array;

    /** @return array<string, bool> */
    public function getStepsData(): array
    {
        return collect($this->steps())
            ->mapWithKeys(fn (OnboardingChecklistStep $step): array => [$step->key() => $step->completed()])
            ->toArray();
    }

    public function percentComplete(): int
    {
        $total = 0;
        $completed = 0;

        foreach ($this->steps() as $onboardingChecklistStep) {
            $total += 1;

            if ($onboardingChecklistStep->completed()) {
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
     * @param  list<class-string<OnboardingChecklistStep>>  $stepClasses
     * @return list<OnboardingChecklistStep>
     */
    protected function buildSteps(array $stepClasses): array
    {
        return array_map(
            fn (string $class): OnboardingChecklistStep => new $class($this->model->steps),
            $stepClasses
        );
    }
}
