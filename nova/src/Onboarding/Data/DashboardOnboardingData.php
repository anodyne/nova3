<?php

declare(strict_types=1);

namespace Nova\Onboarding\Data;

use Bag\Bag;
use Nova\Onboarding\Models\Onboarding;

/**
 * @method static static from(Onboarding $model, string $label, string $description, int $percentComplete, string $ctaLabel)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class DashboardOnboardingData extends Bag
{
    public function __construct(
        public Onboarding $model,
        public string $label,
        public string $description,
        public int $percentComplete,
        public string $ctaLabel
    ) {}
}
