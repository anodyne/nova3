<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Onboarding\Models\Onboarding;

trait HasOnboarding
{
    public function activeOnboardings(): BelongsToMany
    {
        return $this->onboardings()
            ->wherePivotNull('completed_at');
    }

    public function onboardings(): BelongsToMany
    {
        return $this->belongsToMany(Onboarding::class)
            ->withPivot(['completed_at']);
    }
}
