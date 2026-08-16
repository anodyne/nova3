<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Foundation\Helpers\TimeHelper;
use Nova\Foundation\Models\Model;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Events\PostCreated;
use Nova\Stories\Events\PostCreating;
use Nova\Stories\Events\PostDeleted;
use Nova\Stories\Events\PostSaved;
use Nova\Stories\Events\PostSaving;
use Nova\Stories\Events\PostUpdated;
use Nova\Stories\Models\Builders\PostBuilder;
use Nova\Stories\Models\Concerns\HasContentRatings;
use Nova\Stories\Models\States\PostStatus;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\States\PostStatus\Started;
use Nova\Stories\Observers\PostObserver;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $story_id
 * @property int|null $post_type_id
 * @property int|null $order_column
 * @property \Nova\Stories\Models\States\PostStatus\PostStatus $status
 * @property string|null $title
 * @property string|null $content
 * @property string|null $day
 * @property string|null $time
 * @property string|null $location
 * @property int $word_count
 * @property ContentRatingValue|null $rating_language
 * @property ContentRatingValue|null $rating_sex
 * @property ContentRatingValue|null $rating_violence
 * @property string|null $summary
 * @property array<array-key, mixed>|null $participants
 * @property int|null $neighbor
 * @property string|null $direction
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property \Carbon\CarbonImmutable|null $locked_at
 * @property int|null $locked_by
 * @property int|null $last_update_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read array $authors_avatars
 * @property-read string $authors_string
 * @property-read \Nova\Stories\Models\PostAuthor|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Character> $characterAuthors
 * @property-read int|null $character_authors_count
 * @property-read bool $has_location_and_time
 * @property-read bool $is_draft
 * @property-read bool $is_pending
 * @property-read bool $is_published
 * @property-read bool $is_setup
 * @property-read bool $is_started
 * @property-read string $location_day_time
 * @property-read User|null $lockOwner
 * @property-read bool $needs_attention
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $participatingUsers
 * @property-read int|null $participating_users_count
 * @property-read \Nova\Stories\Models\PostType|null $postType
 * @property-read string $reading_time
 * @property-read bool $show_content_warning_for_admin_site
 * @property-read bool $show_content_warning_for_public_site
 * @property-read \Nova\Stories\Models\Story|null $story
 * @property-read string|null $timeline
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $userAuthors
 * @property-read int|null $user_authors_count
 * @method static PostBuilder<static>|Post abandoned()
 * @method static PostBuilder<static>|Post currentMonth()
 * @method static PostBuilder<static>|Post currentYear()
 * @method static PostBuilder<static>|Post draft()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static PostBuilder<static>|Post hasExpiredPostLock()
 * @method static PostBuilder<static>|Post locked()
 * @method static PostBuilder<static>|Post newModelQuery()
 * @method static PostBuilder<static>|Post newQuery()
 * @method static Builder<static>|Post onlyTrashed()
 * @method static PostBuilder<static>|Post orWhereNotState(string $column, $states)
 * @method static PostBuilder<static>|Post orWhereState(string $column, $states)
 * @method static PostBuilder<static>|Post ordered(string $direction = 'asc')
 * @method static PostBuilder<static>|Post pending()
 * @method static PostBuilder<static>|Post previousMonth()
 * @method static PostBuilder<static>|Post previousYear()
 * @method static PostBuilder<static>|Post published()
 * @method static PostBuilder<static>|Post query()
 * @method static PostBuilder<static>|Post searchFor($search)
 * @method static PostBuilder<static>|Post story(\Nova\Stories\Models\Story|int $story)
 * @method static PostBuilder<static>|Post unlocked()
 * @method static PostBuilder<static>|Post whereContent($value)
 * @method static PostBuilder<static>|Post whereCreatedAt($value)
 * @method static PostBuilder<static>|Post whereDay($value)
 * @method static PostBuilder<static>|Post whereDeletedAt($value)
 * @method static PostBuilder<static>|Post whereDirection($value)
 * @method static PostBuilder<static>|Post whereHasUser(\Nova\Users\Models\User $user)
 * @method static PostBuilder<static>|Post whereId($value)
 * @method static PostBuilder<static>|Post whereLastUpdateBy($value)
 * @method static PostBuilder<static>|Post whereLocation($value)
 * @method static PostBuilder<static>|Post whereLockedAt($value)
 * @method static PostBuilder<static>|Post whereLockedBy($value)
 * @method static PostBuilder<static>|Post whereNeighbor($value)
 * @method static PostBuilder<static>|Post whereNotPost(\Nova\Stories\Models\Post $post)
 * @method static PostBuilder<static>|Post whereNotRootPost()
 * @method static PostBuilder<static>|Post whereNotState(string $column, $states)
 * @method static PostBuilder<static>|Post whereOrderColumn($value)
 * @method static PostBuilder<static>|Post whereParticipants($value)
 * @method static PostBuilder<static>|Post wherePostType($postTypeId)
 * @method static PostBuilder<static>|Post wherePostTypeId($value)
 * @method static PostBuilder<static>|Post wherePrefixedId($value)
 * @method static PostBuilder<static>|Post wherePublishedAt($value)
 * @method static PostBuilder<static>|Post whereRatingLanguage($value)
 * @method static PostBuilder<static>|Post whereRatingSex($value)
 * @method static PostBuilder<static>|Post whereRatingViolence($value)
 * @method static PostBuilder<static>|Post whereState(string $column, $states)
 * @method static PostBuilder<static>|Post whereStatus($value)
 * @method static PostBuilder<static>|Post whereStoryId($value)
 * @method static PostBuilder<static>|Post whereSummary($value)
 * @method static PostBuilder<static>|Post whereTime($value)
 * @method static PostBuilder<static>|Post whereTitle($value)
 * @method static PostBuilder<static>|Post whereUpdatedAt($value)
 * @method static PostBuilder<static>|Post whereWordCount($value)
 * @method static Builder<static>|Post withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Post withoutTrashed()
 * @mixin \Eloquent
 */
#[ObservedBy([PostObserver::class])]
#[UseEloquentBuilder(PostBuilder::class)]
class Post extends Model implements Sortable
{
    use HasContentRatings;
    use HasFactory;
    use HasPrefixedId;
    use HasStates;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }
    use Searchable;
    use SoftDeletes;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    protected $table = 'posts';

    protected $fillable = [
        'id', 'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count',
        'day', 'time', 'location', 'rating_language', 'rating_sex',
        'rating_violence', 'summary', 'participants', 'neighbor', 'direction',
        'order_column', 'locked_at', 'locked_by', 'last_update_by',
    ];

    protected $with = ['postType', 'story'];

    protected $casts = [
        'locked_at' => 'datetime',
        'locked_by' => 'integer',
        'participants' => 'array',
        'published_at' => 'datetime',
        'rating_language' => ContentRatingValue::class,
        'rating_sex' => ContentRatingValue::class,
        'rating_violence' => ContentRatingValue::class,
        'status' => PostStatus\PostStatus::class,
        'word_count' => 'integer',
    ];

    protected $dispatchesEvents = [
        'creating' => PostCreating::class,
        'created' => PostCreated::class,
        'deleted' => PostDeleted::class,
        'saved' => PostSaved::class,
        'saving' => PostSaving::class,
        'updated' => PostUpdated::class,
    ];

    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_author')
            ->withTrashed()
            ->withPivot(['post_id', 'user_id', 'updated_at', 'word_count']);
    }

    public function characterAuthors(): MorphToMany
    {
        return $this->morphedByMany(Character::class, 'authorable', 'post_author')
            ->withPivot('user_id')
            ->using(PostAuthor::class)
            ->withTimestamps();
    }

    public function userAuthors(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'authorable', 'post_author')
            ->withPivot(['as', 'user_id'])
            ->withTrashed()
            ->using(PostAuthor::class)
            ->withTimestamps();
    }

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function postType(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(PostType::class)->withTrashed();

        return $relation;
    }

    public function lockOwner(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class, 'locked_by')->withTrashed();

        return $relation;
    }

    public function isDraft(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Draft::class)
        );
    }

    public function isPending(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Published::class)
        );
    }

    public function isSetup(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->post_type_id) && filled($this->story_id)
        );
    }

    public function isStarted(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Started::class)
        );
    }

    public function hasLocationAndTime(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->day) || filled($this->time) || filled($this->location)
        );
    }

    public function needsAttention(): Attribute
    {
        return Attribute::make(
            // get: fn (): bool => $this->participatingUsers()->latest('pivot_updated_at')->first()?->pivot?->user_id !== Auth::id()
            get: fn (): bool => $this->last_update_by !== Auth::id()
        );
    }

    public function readingTime(): Attribute
    {
        return Attribute::make(
            get: fn (): string => TimeHelper::readingTime($this->word_count)
        );
    }

    public function timeline(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => collect([$this->day, $this->time])->filter()->join(', ')
        );
    }

    public function authorsAvatars(): Attribute
    {
        return Attribute::make(
            get: function (): array {
                return collect(array_merge(
                    $this->characterAuthors->map(fn ($character) => $character->avatar_url)->all(),
                    $this->userAuthors->map(fn ($user) => $user->avatar_url)->all(),
                ))->all();
            }
        );
    }

    public function authorsString(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return collect(array_merge(
                    $this->characterAuthors->map(fn ($character) => $character->display_name)->all(),
                    $this->userAuthors->map(fn ($user) => filled($user->pivot->as) ? "{$user->name} as {$user->pivot->as}" : $user->name)->all(),
                ))->join(', ', ', and ');
            }
        );
    }

    public function locationDayTime(): Attribute
    {
        return Attribute::make(
            get: fn (): string => collect([$this->location, $this->day, $this->time])->filter()->join(', ')
        );
    }

    public function addParticipant(User $user): void
    {
        $participants = collect($this->participants)
            ->filter()
            ->push($user->id)
            ->unique()
            ->values()
            ->all();

        $this->fill(['participants' => $participants])->save();
    }

    public function removeParticipant(int $userId): void
    {
        $this->characterAuthors()->wherePivot('user_id', $userId)->detach();

        $this->userAuthors()->wherePivot('user_id', $userId)->detach();

        $participants = collect($this->participants)
            ->filter()
            ->filter(fn ($participant) => $participant !== $userId)
            ->unique()
            ->values()
            ->map(fn ($value): int => (int) $value)
            ->toArray();

        $this->fill(['participants' => $participants])->save();
    }

    public function removeAllNonParticipants(): void
    {
        $this->participatingUsers()
            ->newPivotStatement()
            ->where('post_id', $this->id)
            ->whereNotIn('user_id', $this->participants)
            ->delete();
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->story($this->story)
            ->whereNotState('status', Started::class);
    }

    public function shouldSortWhenCreating(): bool
    {
        return true;
    }

    public function nextSibling($status = null, array $types = [], int $skip = 0): ?self
    {
        return $this->getSibling('next', $status, $types, $skip);
    }

    public function previousSibling($status = null, array $types = [], int $skip = 0): ?self
    {
        return $this->getSibling('previous', $status, $types, $skip);
    }

    public function isLocked(): bool
    {
        return $this->locked_by !== null && $this->locked_at !== null && $this->locked_at->diffInMinutes(now()) < 5;
    }

    public function lockIsOwnedBy(User $user): bool
    {
        return $this->locked_by === $user->id;
    }

    public function lock(User $user)
    {
        activity()
            ->causedBy($user)
            ->performedOn($this)
            ->event('locked')
            ->log('locked');

        activity()->withoutLogs(function () use ($user) {
            $this->update([
                'locked_by' => $user->id,
                'locked_at' => now(),
            ]);
        });
    }

    public function unlock()
    {
        activity()
            ->performedOn($this)
            ->event('unlocked')
            ->log('unlocked');

        activity()->withoutLogs(function () {
            $this->update([
                'locked_by' => null,
                'locked_at' => null,
            ]);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'content',
            'direction',
            'neighbor',
            'participants',
            'word_count',
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'prefixed_id' => $this->prefixed_id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_published;
    }

    protected function getSibling($direction, $status, array $types = [], int $skip = 0)
    {
        $query = self::query()
            ->story($this->story_id)
            ->when($status, fn (Builder $query) => $query->whereState('status', $status))
            ->when(
                count($types) > 0,
                fn (Builder $query) => $query->whereHas('postType', fn (Builder $query) => $query->whereIn('key', $types))
            );

        return match ($direction) {
            'previous' => $query->where('order_column', '<', $this->order_column)->orderByDesc('order_column')->skip($skip)->first(),
            'next' => $query->where('order_column', '>', $this->order_column)->orderBy('order_column')->skip($skip)->first(),
            default => $query->first(),
        };
    }
}
