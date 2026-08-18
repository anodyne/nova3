<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Events\ApplicationCreated;
use Nova\Applications\Models\Builders\ApplicationBuilder;
use Nova\Characters\Models\Character;
use Nova\Discussions\Concerns\Discussable;
use Nova\Discussions\Models\Discussion;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $user_id
 * @property int|null $character_id
 * @property string|null $ip_address
 * @property ApplicationResult $result
 * @property string|null $decision_message
 * @property CarbonImmutable|null $decision_date
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read ApplicationReview|null $pivot
 * @property-read Collection<int, User> $acceptedReviews
 * @property-read int|null $accepted_reviews_count
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read FormSubmission|null $applicationFormSubmission
 * @property-read Character|null $character
 * @property-read Collection<int, User> $deniedReviews
 * @property-read int|null $denied_reviews_count
 * @property-read Discussion|null $discussion
 * @property-read Collection<int, User> $noResultReviews
 * @property-read int|null $no_result_reviews_count
 * @property-read Collection<int, User> $reviews
 * @property-read int|null $reviews_count
 * @property-read User|null $user
 *
 * @method static \Database\Factories\ApplicationFactory factory($count = null, $state = [])
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application newModelQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application newQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application pending()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application query()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application reviewedBy(\Nova\Users\Models\User $user)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application searchFor($search)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereCharacterId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereCreatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereDecisionDate($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereDecisionMessage($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereIpAddress($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application wherePrefixedId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereResult($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereUpdatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(ApplicationBuilder::class)]
class Application extends Model
{
    use Discussable;
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $casts = [
        'decision_date' => 'datetime',
        'result' => ApplicationResult::class,
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
    ];

    protected $fillable = [
        'character_id',
        'decision_date',
        'decision_message',
        'ip_address',
        'result',
        'user_id',
    ];

    public function acceptedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Accept);
    }

    public function applicationFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereRelation('form', 'key', '=', 'applicationInfo');
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function deniedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Deny);
    }

    public function noResultReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivotNull('result');
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'application_review')
            ->withPivot(['result', 'comments', 'id'])
            ->withTrashed()
            ->using(ApplicationReview::class);
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
