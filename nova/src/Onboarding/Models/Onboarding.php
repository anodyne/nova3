<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Builders\OnboardingBuilder;
use Nova\Onboarding\Observers\OnboardingObserver;
use Nova\Users\Models\User;

#[ObservedBy([OnboardingObserver::class])]
class Onboarding extends Model
{
    protected $table = 'onboarding';

    protected $fillable = ['process', 'completed_at', 'user_id', 'steps'];

    protected $casts = [
        'process' => OnboardingProcess::class,
        'steps' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newEloquentBuilder($query): OnboardingBuilder
    {
        return new OnboardingBuilder($query);
    }
}
