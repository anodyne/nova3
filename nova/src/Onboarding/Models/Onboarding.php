<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Builders\OnboardingBuilder;
use Nova\Onboarding\Observers\OnboardingObserver;
use Nova\Users\Models\User;

/**
 * @mixin IdeHelperOnboarding
 */
#[ObservedBy([OnboardingObserver::class])]
#[UseEloquentBuilder(OnboardingBuilder::class)]
class Onboarding extends Model
{
    protected $casts = [
        'process' => OnboardingProcess::class,
        'steps' => 'array',
    ];

    protected $fillable = ['process', 'completed_at', 'user_id', 'steps'];

    protected $table = 'onboarding';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
