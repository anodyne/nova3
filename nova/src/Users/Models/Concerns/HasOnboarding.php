<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Onboarding\Models\Onboarding;

trait HasOnboarding
{
    /**
     * @return HasMany<Onboarding, $this>
     */
    public function activeOnboardings(): HasMany
    {
        return once(fn () => $this->onboardings()->incomplete());
    }

    /**
     * @return HasMany<Onboarding, $this>
     */
    public function onboardings(): HasMany
    {
        return $this->HasMany(Onboarding::class);
    }
}
