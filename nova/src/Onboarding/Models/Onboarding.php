<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding incomplete()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding newModelQuery()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding newQuery()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding process(\Nova\Onboarding\Enums\OnboardingProcess $process)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding query()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding user(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereCompletedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereCreatedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereId($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereProcess($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereSteps($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereUpdatedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereUserId($value)
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
