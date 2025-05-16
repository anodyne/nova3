<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Onboarding\Models\Onboarding;

trait HasOnboarding
{
    public function activeOnboardings(): HasMany
    {
        return once(fn () => $this->onboardings()->incomplete());
    }

    public function onboardings(): HasMany
    {
        return $this->HasMany(Onboarding::class);
    }
}
