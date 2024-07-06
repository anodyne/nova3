<?php

declare(strict_types=1);

namespace Nova\Stories\Wizard;

use Illuminate\Support\Arr;

class Step
{
    public function __construct(
        public string $stepName,
        public array $info,
        public StepStatus $status,
    ) {}

    public function isPrevious(): bool
    {
        return $this->status === StepStatus::Previous;
    }

    public function isCurrent(): bool
    {
        return $this->status === StepStatus::Current;
    }

    public function isNext(): bool
    {
        return $this->status === StepStatus::Next;
    }

    public function show(): string
    {
        return '$dispatch(\'showStep\', { toStepName: \''.$this->stepName.'\' })';
    }

    public function __get(string $key): mixed
    {
        return Arr::get($this->info, $key);
    }
}
