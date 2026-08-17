<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Carbon\CarbonImmutable;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\HasManyOfDescendants;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $parent_id
 * @property int|null $order_column
 * @property \Nova\Stories\Models\States\StoryStatus\StoryStatus $status
 * @property string $title
 * @property string|null $description
 * @property string|null $summary
 * @property mixed|null $started_at
 * @property mixed|null $ended_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $allPosts
 * @property-read int|null $all_posts_count
 * @property-read bool $can_post
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $children
 * @property-read int|null $children_count
 * @property-read bool $has_summary
 * @property-read bool $is_completed
 * @property-read bool $is_current
 * @property-read bool $is_ongoing
 * @property-read bool $is_upcoming
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read \Nova\Stories\Models\Story|null $parent
 * @property-read Story|null $parentStory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $recursiveStories
 * @property-read int|null $recursive_stories_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $stories
 * @property-read int|null $stories_count
 * @property-read int $depth
 * @property-read string $path
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \Nova\Stories\Models\Story|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static StoryBuilder<static>|Story breadthFirst()
 * @method static StoryBuilder<static>|Story completed()
 * @method static StoryBuilder<static>|Story current()
 * @method static StoryBuilder<static>|Story depthFirst()
 * @method static StoryBuilder<static>|Story doesntHaveChildren()
 * @method static StoryBuilder<static>|Story exceptCompleted()
 * @method static StoryBuilder<static>|Story exceptUpcoming()
 * @method static \Database\Factories\StoryFactory factory($count = null, $state = [])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static StoryBuilder<static>|Story getExpressionGrammar()
 * @method static StoryBuilder<static>|Story hasChildren()
 * @method static StoryBuilder<static>|Story hasParent()
 * @method static StoryBuilder<static>|Story isLeaf()
 * @method static StoryBuilder<static>|Story isRoot()
 * @method static StoryBuilder<static>|Story newModelQuery()
 * @method static StoryBuilder<static>|Story newQuery()
 * @method static StoryBuilder<static>|Story ongoing()
 * @method static StoryBuilder<static>|Story orWhereNotState(string $column, $states)
 * @method static StoryBuilder<static>|Story orWhereState(string $column, $states)
 * @method static StoryBuilder<static>|Story ordered(string $direction = 'asc')
 * @method static StoryBuilder<static>|Story query()
 * @method static StoryBuilder<static>|Story searchFor($search)
 * @method static StoryBuilder<static>|Story selectStatusCounts()
 * @method static StoryBuilder<static>|Story selectTotalCount()
 * @method static StoryBuilder<static>|Story tree($maxDepth = null)
 * @method static StoryBuilder<static>|Story treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static StoryBuilder<static>|Story upcoming()
 * @method static StoryBuilder<static>|Story whereCreatedAt($value)
 * @method static StoryBuilder<static>|Story whereDepth($operator, $value = null)
 * @method static StoryBuilder<static>|Story whereDescription($value)
 * @method static StoryBuilder<static>|Story whereEndedAt($value)
 * @method static StoryBuilder<static>|Story whereId($value)
 * @method static StoryBuilder<static>|Story whereNotState(string $column, $states)
 * @method static StoryBuilder<static>|Story whereOrderColumn($value)
 * @method static StoryBuilder<static>|Story whereParent(\Nova\Stories\Models\Story|int|null $parent)
 * @method static StoryBuilder<static>|Story whereParentId($value)
 * @method static StoryBuilder<static>|Story wherePrefixedId($value)
 * @method static StoryBuilder<static>|Story whereStartedAt($value)
 * @method static StoryBuilder<static>|Story whereState(string $column, $states)
 * @method static StoryBuilder<static>|Story whereStatus($value)
 * @method static StoryBuilder<static>|Story whereSummary($value)
 * @method static StoryBuilder<static>|Story whereTitle($value)
 * @method static StoryBuilder<static>|Story whereUpdatedAt($value)
 * @method static StoryBuilder<static>|Story withCountsAndSums()
 * @method static StoryBuilder<static>|Story withGlobalScopes(array $scopes)
 * @method static StoryBuilder<static>|Story withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @mixin \Eloquent
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

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'started_at',
        'ended_at', 'order_column',
    ];

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

    public function allPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'story_id')->ordered();
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

    public function stories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function canPost(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Current::class)
        );
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

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'description',
            'summary',
        ]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('story-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media-stories');
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

    public function buildSortQuery(): Builder
    {
        return static::query()->whereParent($this->parent_id);
    }

    public function nextSibling(): ?self
    {
        return $this->getSibling('next');
    }

    public function previousSibling(): ?self
    {
        return $this->getSibling('previous');
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
            ->sortBy(fn (StoryStatus\StoryStatus $status) => $status->order());
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
