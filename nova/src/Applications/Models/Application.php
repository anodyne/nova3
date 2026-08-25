<?php

declare(strict_types=1);

namespace Nova\Applications\Models;

use Database\Factories\ApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Events\ApplicationCreated;
use Nova\Applications\Models\Builders\ApplicationBuilder;
use Nova\Characters\Models\Character;
use Nova\Discussions\Concerns\Discussable;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperApplication
 */
#[UseEloquentBuilder(ApplicationBuilder::class)]
class Application extends Model
{
    use Discussable;

    /** @use HasFactory<ApplicationFactory> */
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

    /**
     * @return BelongsToMany<User, $this, ApplicationReview, 'pivot'>
     */
    public function acceptedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Accept);
    }

    /**
     * @return MorphOne<FormSubmission, $this>
     */
    public function applicationFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereRelation('form', 'key', '=', 'applicationInfo');
    }

    /**
     * @return BelongsTo<Character, $this>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * @return BelongsToMany<User, $this, ApplicationReview, 'pivot'>
     */
    public function deniedReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivot('result', ApplicationResult::Deny);
    }

    /**
     * @return BelongsToMany<User, $this, ApplicationReview, 'pivot'>
     */
    public function noResultReviews(): BelongsToMany
    {
        return $this->reviews()->wherePivotNull('result');
    }

    /**
     * @return BelongsToMany<User, $this, ApplicationReview, 'pivot'>
     */
    public function reviews(): BelongsToMany
    {
        /** @var BelongsToMany<User, $this, ApplicationReview, 'pivot'> $relation */
        $relation = $this->belongsToMany(User::class, 'application_review')
            ->withPivot(['result', 'comments', 'id'])
            ->withTrashed()
            ->using(ApplicationReview::class);

        return $relation;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
