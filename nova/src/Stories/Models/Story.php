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
 * @property StoryStatus\StoryStatus $status
 * @property string $title
 * @property string|null $description
 * @property string|null $summary
 * @property mixed|null $started_at
 * @property mixed|null $ended_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $allPosts
 * @property-read int|null $all_posts_count
 * @property-read bool $can_post
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $children
 * @property-read int|null $children_count
 * @property-read bool $has_summary
 * @property-read bool $is_completed
 * @property-read bool $is_current
 * @property-read bool $is_ongoing
 * @property-read bool $is_upcoming
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Story|null $parent
 * @property-read Story|null $parentStory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $recursiveStories
 * @property-read int|null $recursive_stories_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $stories
 * @property-read int|null $stories_count
 * @property-read int $depth
 * @property-read string $path
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read Story|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Story> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 *
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story breadthFirst()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story completed()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story current()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story depthFirst()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story doesntHaveChildren()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story exceptCompleted()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story exceptUpcoming()
 * @method static \Database\Factories\StoryFactory factory($count = null, $state = [])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story getExpressionGrammar()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story hasChildren()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story hasParent()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story isLeaf()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story isRoot()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story newModelQuery()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story newQuery()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story ongoing()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story orWhereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story orWhereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story ordered(string $direction = 'asc')
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story query()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story searchFor($search)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story selectStatusCounts()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story selectTotalCount()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story tree($maxDepth = null)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story upcoming()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereCreatedAt($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereDepth($operator, $value = null)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereDescription($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereEndedAt($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereId($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereOrderColumn($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereParent(\Nova\Stories\Models\Story|int|null $parent)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereParentId($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story wherePrefixedId($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereStartedAt($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereStatus($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereSummary($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereTitle($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story whereUpdatedAt($value)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story withCountsAndSums()
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story withGlobalScopes(array $scopes)
 * @method static \Nova\Stories\Models\Builders\StoryBuilder<static>|\Nova\Stories\Models\Story withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 *
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

    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
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
