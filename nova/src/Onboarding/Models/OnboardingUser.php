<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OnboardingUser extends Pivot
{
    protected $table = 'onboarding_user';

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
