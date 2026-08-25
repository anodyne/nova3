<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Onboarding;

/**
 * @extends Builder<Onboarding>
 */
class OnboardingBuilder extends Builder
{
    public function incomplete(): self
    {
        return $this->whereNull('completed_at');
    }

    public function process(OnboardingProcess $process): self
    {
        return $this->where('process', $process);
    }

    public function user(Authenticatable $user): self
    {
        return $this->where('user_id', $user->getAuthIdentifier());
    }
}
