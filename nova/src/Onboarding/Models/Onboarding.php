<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Builders\OnboardingBuilder;
use Nova\Onboarding\Observers\OnboardingObserver;
use Nova\Users\Models\User;

/**
 * @property int $id
 * @property OnboardingProcess $process
 * @property int $user_id
 * @property string|null $completed_at
 * @property array<array-key, mixed>|null $steps
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $user
 *
 * @method static OnboardingBuilder<static>|Onboarding incomplete()
 * @method static OnboardingBuilder<static>|Onboarding newModelQuery()
 * @method static OnboardingBuilder<static>|Onboarding newQuery()
 * @method static OnboardingBuilder<static>|Onboarding process(OnboardingProcess $process)
 * @method static OnboardingBuilder<static>|Onboarding query()
 * @method static OnboardingBuilder<static>|Onboarding user(Authenticatable $user)
 * @method static OnboardingBuilder<static>|Onboarding whereCompletedAt($value)
 * @method static OnboardingBuilder<static>|Onboarding whereCreatedAt($value)
 * @method static OnboardingBuilder<static>|Onboarding whereId($value)
 * @method static OnboardingBuilder<static>|Onboarding whereProcess($value)
 * @method static OnboardingBuilder<static>|Onboarding whereSteps($value)
 * @method static OnboardingBuilder<static>|Onboarding whereUpdatedAt($value)
 * @method static OnboardingBuilder<static>|Onboarding whereUserId($value)
 *
 * @mixin \Eloquent
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
