<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Nova\Foundation\Casts\DateTimeCast;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Events;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\StoryStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\LaravelData\WithData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Story extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasRecursiveRelationships;
    use HasStates;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;
    use WithData;

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'started_at',
        'ended_at', 'order_column',
    ];

    protected $casts = [
        'ended_at' => DateTimeCast::class,
        'parent_id' => 'integer',
        'order_column' => 'integer',
        'started_at' => DateTimeCast::class,
        'status' => StoryStatus\StoryStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\StoryCreated::class,
        'deleted' => Events\StoryDeleted::class,
        'updated' => Events\StoryUpdated::class,
    ];

    protected $dataClass = StoryData::class;

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

    public function recursivePosts()
    {
        return $this->hasManyOfDescendantsAndSelf(Post::class)
            ->published()
            ->ordered();
    }

    public function stories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function recursiveStories(): HasMany
    {
        return $this->stories()->with('recursiveStories');
    }

    public function hasSummary(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->summary && filled(strip_tags($this->summary))
        );
    }

    public function canPost(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(StoryStatus\Current::class)
        );
    }

    public function isCompleted(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(StoryStatus\Completed::class)
        );
    }

    public function isCurrent(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(StoryStatus\Current::class)
        );
    }

    public function isOngoing(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(StoryStatus\Ongoing::class)
        );
    }

    public function isUpcoming(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(StoryStatus\Upcoming::class)
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.title story was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.title story was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('story-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media');
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->parent($this->parent_id);
    }

    public function nextSibling(): ?self
    {
        return $this->getSibling('next');
    }

    public function previousSibling(): ?self
    {
        return $this->getSibling('previous');
    }

    protected function getSibling($direction)
    {
        $query = self::query()->parent($this->parent_id);

        return match ($direction) {
            'previous' => $query->where('order_column', $this->order_column - 1)->first(),
            'next' => $query->where('order_column', $this->order_column + 1)->first(),
            default => $query->first(),
        };
    }

    public static function getMediaPath(): string
    {
        return 'stories/{model_id}/{media_id}/';
    }

    public static function getStatuses(): Collection
    {
        $model = new static();

        return StoryStatus\StoryStatus::all()
            ->flatMap(fn (string $className): array => [new $className($model)])
            ->sortBy(fn ($status) => $status->order());
    }
}
