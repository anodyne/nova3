<?php

declare(strict_types=1);

namespace Nova\Onboarding\Onboarding;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class OnboardingChecklistStep
{
    protected bool $stepIsCompleted;

    /** @param array<string, bool>|null $stepsData */
    public function __construct(?array $stepsData = null)
    {
        $this->stepIsCompleted = Arr::boolean($stepsData ?? [], $this->key(), false);
    }

    abstract public function label(): string;

    public function completed(): bool
    {
        return $this->stepIsCompleted;
    }

    public function description(): ?string
    {
        return null;
    }

    public function key(): string
    {
        $stringable = Str::of(get_class_name(static::class));

        return $stringable->snake()->slug()->toString();
    }

    public function isComplete(): bool
    {
        return false;
    }

    public function isManuallyCompletable(): bool
    {
        $base = self::class;
        $child = static::class;

        // If the class does NOT override isComplete(), it's manually completable
        return new ReflectionClass($child)->getMethod('isComplete')->getDeclaringClass()->name === $base;
    }

    public function linkLabel(): ?string
    {
        return null;
    }

    public function linkUrl(): ?string
    {
        return null;
    }
}
