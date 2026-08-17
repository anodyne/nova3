<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Applications\Enums\ReviewerType;
use Nova\Applications\Models\Builders\ApplicationReviewerBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\Scopes\ActiveUsers;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property int $user_id
 * @property ReviewerType $type
 * @property array<array-key, mixed>|null $conditions
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read User|null $user
 *
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer conditional()
 * @method static \Database\Factories\ApplicationReviewerFactory factory($count = null, $state = [])
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer global()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer globalReviewersWithApprovalPermission()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer newModelQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer newQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer query()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereConditions($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereCreatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereType($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereUpdatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[ScopedBy(ActiveUsers::class)]
#[UseEloquentBuilder(ApplicationReviewerBuilder::class)]
class ApplicationReviewer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'conditions' => 'array',
        'type' => ReviewerType::class,
    ];

    protected $fillable = [
        'conditions',
        'type',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
