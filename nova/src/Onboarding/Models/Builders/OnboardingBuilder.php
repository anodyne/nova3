<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Users\Models\User;

class OnboardingBuilder extends Builder
{
    public function incomplete(): self
    {
        return $this;
    }

    public function key(OnboardingProcess $process): self
    {
        return $this->where('key', $process);
    }

    public function user(Authenticatable $user): self
    {
        return $this->whereRelation('users', User::column('id'), '=', $user->id);
    }
}
