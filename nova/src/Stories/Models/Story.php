<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Nova\Foundation\Casts\DateTimeCast;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Foundation\Models\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Stories\Events\StoryCreated;
use Nova\Stories\Events\StoryDeleted;
use Nova\Stories\Events\StoryUpdated;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\StoryStatus;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\States\StoryStatus\Ongoing;
use Nova\Stories\Models\States\StoryStatus\Upcoming;
use Spatie\Activitylog\LogOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants;

/**
 * @mixin IdeHelperStory
 */
class Story extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasRecursiveRelationships;
    use HasStates;
    use InteractsWithMedia;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }
    use Searchable;
    use SortableTrait;

    protected $casts = [
        'ended_at' => DateTimeCast::class,
        'order_column' => 'integer',
        'parent_id' => 'integer',
        'started_at' => DateTimeCast::class,
        'status' => StoryStatus\StoryStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => StoryCreated::class,
        'deleted' => StoryDeleted::class,
        'updated' => StoryUpdated::class,
    ];

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'started_at',
        'ended_at', 'order_column',
    ];

    protected $table = 'stories';

    public function allPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'story_id')->ordered();
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->whereParent($this->parent_id);
    }

    public function canPost(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Current::class)
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'description',
            'summary',
        ]);
    }

    public function hasSummary(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->summary && filled(strip_tags($this->summary))
        );
    }

    public function isCompleted(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Completed::class)
        );
    }

    public function isCurrent(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Current::class)
        );
    }

    public function isOngoing(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Ongoing::class)
        );
    }

    public function isUpcoming(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Upcoming::class)
        );
    }

    public function loadCountsAndSums(): self
    {
        if (app('nova.environment')->database->isMysql()) {
            return $this
                ->loadCount('posts', 'recursivePosts', 'children')
                ->loadSum(['recursivePosts', 'posts'], 'word_count');
        }

        return $this
            ->loadCount('posts', 'children')
            ->loadSum('posts', 'word_count');
    }

    public function nextSibling(): ?self
    {
        return $this->getSibling('next');
    }

    public function parentStory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'story_id')
            ->published()
            ->ordered();
    }

    public function previousSibling(): ?self
    {
        return $this->getSibling('previous');
    }

    public function recursivePosts(): HasManyOfDescendants
    {
        return $this->hasManyOfDescendantsAndSelf(Post::class)
            ->published()
            ->ordered();
    }

    public function recursiveStories(): HasMany
    {
        return $this->stories()->with('recursiveStories');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('story-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-stories');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'prefixed_id' => $this->prefixed_id,
            'title' => $this->title,
        ];
    }

    /**
     * @param  \Illuminate\Database\Query\Builder  $query
     */
    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/';
    }

    public static function getStatuses(): Collection
    {
        $model = new self;

        return StoryStatus\StoryStatus::all()
            ->flatMap(fn (string $className): array => [new $className($model)])
            ->sortBy(fn (StoryStatus\StoryStatus $status): int => $status->order());
    }

    protected function getSibling($direction): ?self
    {
        $query = self::query()->whereParent($this->parent_id);

        return match ($direction) {
            'previous' => $query->where('order_column', $this->order_column - 1)->first(),
            'next' => $query->where('order_column', $this->order_column + 1)->first(),
            default => $query->first(),
        };
    }
}
