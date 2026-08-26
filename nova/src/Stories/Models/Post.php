<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Database\Factories\PostFactory;
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
use Spatie\Activitylog\Support\LogOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperPost
 */
#[ObservedBy([PostObserver::class])]
#[UseEloquentBuilder(PostBuilder::class)]
class Post extends Model implements Sortable
{
    use HasContentRatings;

    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use HasPrefixedId;
    use HasStates;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }
    use Searchable;
    use SoftDeletes;
    use SortableTrait;

    /** @var array{order_column_name: string, sort_when_creating: bool} */
    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

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

    protected $fillable = [
        'id', 'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count',
        'day', 'time', 'location', 'rating_language', 'rating_sex',
        'rating_violence', 'summary', 'participants', 'neighbor', 'direction',
        'order_column', 'locked_at', 'locked_by', 'last_update_by',
    ];

    protected $table = 'posts';

    protected $with = ['postType', 'story'];

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

    /** @return Attribute<array<int, string>, never> */
    public function authorsAvatars(): Attribute
    {
        return Attribute::make(
            get: fn (): array => collect(array_merge(
                $this->characterAuthors->map(fn ($character) => $character->avatar_url)->all(),
                $this->userAuthors->map(fn ($user) => $user->avatar_url)->all(),
            ))->all()
        );
    }

    /** @return Attribute<string, never> */
    public function authorsString(): Attribute
    {
        return Attribute::make(
            get: fn (): string => collect(array_merge(
                $this->characterAuthors->map(fn ($character) => $character->display_name)->all(),
                $this->userAuthors->map(function (User $user): string {
                    $authorship = $user->getRelation('pivot');

                    if (! $authorship instanceof PostAuthor || blank($authorship->as)) {
                        return $user->name;
                    }

                    return "{$user->name} as {$authorship->as}";
                })->all(),
            ))->join(', ', ', and ')
        );
    }

    /** @return PostBuilder */
    public function buildSortQuery(): Builder
    {
        return static::query()
            ->forStory($this->story)
            ->whereNotState('status', Started::class);
    }

    /** @return MorphToMany<Character, $this, PostAuthor, 'pivot'> */
    public function characterAuthors(): MorphToMany
    {
        return $this->morphedByMany(Character::class, 'authorable', 'post_author')
            ->withPivot(['user_id'])
            ->using(PostAuthor::class)
            ->withTimestamps();
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

    /** @return Attribute<bool, never> */
    public function hasLocationAndTime(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->day) || filled($this->time) || filled($this->location)
        );
    }

    /** @return Attribute<bool, never> */
    public function isDraft(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Draft::class)
        );
    }

    public function isLocked(): bool
    {
        return $this->locked_by !== null && $this->locked_at !== null && $this->locked_at->diffInMinutes(now()) < 5;
    }

    /** @return Attribute<bool, never> */
    public function isPending(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    /** @return Attribute<bool, never> */
    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Published::class)
        );
    }

    /** @return Attribute<bool, never> */
    public function isSetup(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => filled($this->post_type_id) && filled($this->story_id)
        );
    }

    /** @return Attribute<bool, never> */
    public function isStarted(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(Started::class)
        );
    }

    /** @return Attribute<string, never> */
    public function locationDayTime(): Attribute
    {
        return Attribute::make(
            get: fn (): string => collect([$this->location, $this->day, $this->time])->filter()->join(', ')
        );
    }

    public function lock(User $user): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($this)
            ->event('locked')
            ->log('locked');

        activity()->withoutLogging(function () use ($user): void {
            $this->update([
                'locked_by' => $user->id,
                'locked_at' => now(),
            ]);
        });
    }

    public function lockIsOwnedBy(User $user): bool
    {
        return $this->locked_by === $user->id;
    }

    /** @return BelongsTo<User, $this> */
    public function lockOwner(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class, 'locked_by')->withTrashed();

        return $relation;
    }

    /** @return Attribute<bool, never> */
    public function needsAttention(): Attribute
    {
        return Attribute::make(
            // get: fn (): bool => $this->participatingUsers()->latest('pivot_updated_at')->first()?->pivot?->user_id !== Auth::id()
            get: fn (): bool => $this->last_update_by !== Auth::id()
        );
    }

    /**
     * @param  class-string<PostStatus\PostStatus>|null  $status
     * @param  list<string>  $types
     */
    public function nextSibling(?string $status = null, array $types = [], int $skip = 0): ?self
    {
        return $this->getSibling('next', $status, $types, $skip);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_author')
            ->withTrashed()
            ->withPivot(['post_id', 'user_id', 'updated_at', 'word_count']);
    }

    /** @return BelongsTo<PostType, $this> */
    public function postType(): BelongsTo
    {
        /** @var BelongsTo<PostType, $this> $relation */
        $relation = $this->belongsTo(PostType::class)->withTrashed();

        return $relation;
    }

    /**
     * @param  class-string<PostStatus\PostStatus>|null  $status
     * @param  list<string>  $types
     */
    public function previousSibling(?string $status = null, array $types = [], int $skip = 0): ?self
    {
        return $this->getSibling('previous', $status, $types, $skip);
    }

    /** @return Attribute<string, never> */
    public function readingTime(): Attribute
    {
        return Attribute::make(
            get: fn (): string => TimeHelper::readingTime($this->word_count)
        );
    }

    public function removeAllNonParticipants(): void
    {
        $this->participatingUsers()
            ->newPivotStatement()
            ->where('post_id', $this->id)
            ->whereNotIn('user_id', $this->participants)
            ->delete();
    }

    public function removeParticipant(int $userId): void
    {
        $this->characterAuthors()->wherePivot('user_id', $userId)->detach();

        $this->userAuthors()->wherePivot('user_id', $userId)->detach();

        $participants = collect($this->participants)
            ->filter()
            ->filter(fn ($participant): bool => $participant !== $userId)
            ->unique()
            ->values()
            ->map(fn ($value): int => (int) $value)
            ->toArray();

        $this->fill(['participants' => $participants])->save();
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_published;
    }

    public function shouldSortWhenCreating(): bool
    {
        return true;
    }

    /** @return BelongsTo<Story, $this> */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /** @return Attribute<string, never> */
    public function timeline(): Attribute
    {
        return Attribute::make(
            get: fn (): string => collect([$this->day, $this->time])->filter()->join(', ')
        );
    }

    /** @return array<string, mixed> */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'prefixed_id' => $this->prefixed_id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    public function unlock(): void
    {
        activity()
            ->performedOn($this)
            ->event('unlocked')
            ->log('unlocked');

        activity()->withoutLogging(function (): void {
            $this->update([
                'locked_by' => null,
                'locked_at' => null,
            ]);
        });
    }

    /** @return MorphToMany<User, $this, PostAuthor, 'pivot'> */
    public function userAuthors(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'authorable', 'post_author')
            ->withPivot(['as', 'user_id'])
            ->withTrashed()
            ->using(PostAuthor::class)
            ->withTimestamps();
    }

    /**
     * @param  class-string<PostStatus\PostStatus>|null  $status
     * @param  list<string>  $types
     */
    protected function getSibling(string $direction, ?string $status, array $types = [], int $skip = 0): ?self
    {
        $query = self::query()
            ->forStory($this->story_id)
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
