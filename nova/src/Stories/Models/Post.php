<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Stories\Data\PostData;
use Nova\Stories\Events;
use Nova\Stories\Models\Builders\PostBuilder;
use Nova\Stories\Models\States\PostStatus;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\LaravelData\WithData;
use Spatie\ModelStates\HasStates;
use Staudenmeir\EloquentEagerLimitXLaravelAdjacencyList\Eloquent\HasEagerLimitAndRecursiveRelationships;

class Post extends Model implements Sortable
{
    use HasEagerLimitAndRecursiveRelationships;
    use HasFactory;
    use HasStates;
    use LogsActivity;
    use SortableTrait;
    use WithData;

    protected $table = 'posts';

    protected $fillable = [
        'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count',
        'day', 'time', 'location', 'parent_id', 'rating_language', 'rating_sex',
        'rating_violence', 'summary', 'participants', 'neighbor', 'direction',
        'sort',
    ];

    protected $with = ['postType', 'story'];

    protected $casts = [
        'participants' => 'array',
        'published_at' => 'datetime',
        'rating_language' => 'integer',
        'rating_sex' => 'integer',
        'rating_violence' => 'integer',
        'status' => PostStatus\PostStatus::class,
        'word_count' => 'integer',
    ];

    protected $dispatchesEvents = [
        'creating' => Events\PostCreating::class,
        'created' => Events\PostCreated::class,
        'deleted' => Events\PostDeleted::class,
        'saved' => Events\PostSaved::class,
        'saving' => Events\PostSaving::class,
        'updated' => Events\PostUpdated::class,
    ];

    protected $dataClass = PostData::class;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_author')
            ->withPivot(['post_id', 'user_id'])
            ->groupBy('pivot_user_id', 'pivot_post_id');
    }

    public function characterAuthors()
    {
        return $this->morphedByMany(Character::class, 'authorable', 'post_author')
            ->withPivot('user_id')
            ->using(PostAuthor::class);
    }

    public function userAuthors()
    {
        return $this->morphedByMany(User::class, 'authorable', 'post_author')
            ->withPivot(['as', 'user_id'])
            ->using(PostAuthor::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class)->withTrashed();
    }

    public function isDraft(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(PostStatus\Draft::class)
        );
    }

    public function isPending(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(PostStatus\Pending::class)
        );
    }

    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(PostStatus\Published::class)
        );
    }

    public function isStarted(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status->equals(PostStatus\Started::class)
        );
    }

    public function readingTime(): Attribute
    {
        return Attribute::make(
            get: fn (): string => ceil($this->word_count / 200).'m'
        );
    }

    public function showContentWarning(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                $settings = settings('ratings');

                return (filled($settings->sex->warning_threshold) && $this->rating_sex >= settings('ratings.sex.warning_threshold')) ||
                    (filled($settings->language->warning_threshold) && $this->rating_language >= settings('ratings.language.warning_threshold')) ||
                    (filled($settings->violence->warning_threshold) && $this->rating_violence >= settings('ratings.violence.warning_threshold'));
            }
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

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    public function addParticipant(User $user): void
    {
        $participants = collect($this->participants)
            ->filter()
            ->push($user->id)
            ->unique()
            ->all();

        $this->fill(['participants' => $participants])->save();
    }

    public function removeParticipant(User $user): void
    {
        $this->characterAuthors()->wherePivot('user_id', $user->id)->detach();

        $this->userAuthors()->wherePivot('user_id', $user->id)->detach();

        $participants = collect($this->participants)
            ->filter()
            ->filter(fn ($participant) => $participant !== $user->id)
            ->unique()
            ->all();

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

    public function shouldShowContentWarning(): bool
    {
        return $this->rating_language >= 2
            || $this->rating_sex >= 2
            || $this->rating_violence >= 2;
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->story($this->story)
            ->whereNotState('status', PostStatus\Started::class);
    }

    public function nextSibling($status = null): ?self
    {
        return $this->getSibling('next', $status);
    }

    public function previousSibling($status = null): ?self
    {
        return $this->getSibling('previous', $status);
    }

    protected function getSibling($direction, $status)
    {
        $query = self::query()
            ->story($this->story_id)
            ->when($status, fn (Builder $query) => $query->whereState('status', $status));

        return match ($direction) {
            'previous' => $query->where('order_column', '<', $this->order_column)->orderByDesc('order_column')->first(),
            'next' => $query->where('order_column', '>', $this->order_column)->orderBy('order_column')->first(),
            default => $query->first(),
        };
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.title post was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.title post was {$eventName}"
            );
    }
}
