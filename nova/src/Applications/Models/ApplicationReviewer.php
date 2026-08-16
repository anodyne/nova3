<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\Builders\ApplicationReviewerBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\Scopes\ActiveUsers;
use Nova\Users\Models\User;

/**
 * @property int $id
 * @property int $user_id
 * @property ReviewerType $type
 * @property array<array-key, mixed>|null $conditions
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read User|null $user
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer conditional()
 * @method static \Database\Factories\ApplicationReviewerFactory factory($count = null, $state = [])
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer global()
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer globalReviewersWithApprovalPermission()
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer newModelQuery()
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer newQuery()
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer query()
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereConditions($value)
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereCreatedAt($value)
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereId($value)
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereType($value)
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereUpdatedAt($value)
 * @method static ApplicationReviewerBuilder<static>|ApplicationReviewer whereUserId($value)
 * @mixin \Eloquent
 */
#[ScopedBy(ActiveUsers::class)]
#[UseEloquentBuilder(ApplicationReviewerBuilder::class)]
class ApplicationReviewer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'conditions',
        'type',
        'user_id',
    ];

    protected $casts = [
        'conditions' => 'array',
        'type' => ReviewerType::class,
    ];

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
