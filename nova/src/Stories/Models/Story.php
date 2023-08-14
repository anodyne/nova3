<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Posts\Models\Post;
use Nova\Stories\Events;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\StoryStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Story extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasRecursiveRelationships;
    use HasStates;
    use InteractsWithMedia;
    use SortableTrait;
    use LogsActivity;

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'start_date',
        'end_date', 'order_column',
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'parent_id' => 'integer',
        'order_column' => 'integer',
        'start_date' => 'datetime',
        'end_data' => 'datetime',
        'status' => StoryStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\StoryCreated::class,
        'deleted' => Events\StoryDeleted::class,
        'updated' => Events\StoryUpdated::class,
    ];

    public function allPosts()
    {
        return $this->hasMany(Post::class, 'story_id')->ordered();
    }

    public function posts()
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

    public function stories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function recursiveStories(): HasMany
    {
        return $this->stories()->with('recursiveStories');
    }

    public function allStoriesPostCount(): Attribute
    {
        return new Attribute(
            get: function ($value): int {
                if ($this->stories()->count() > 0) {
                    return Story::query()
                        ->where('id', $this->id)
                        ->descendantsAndSelf()
                        ->sum('postCount');
                }

                return 0;
            }
        );
    }

    public function wordsCount(): Attribute
    {
        return new Attribute(
            get: function ($value): int {
                return (int) $this->posts()->sum('word_count');
            }
        );
    }

    public function canPost(): Attribute
    {
        return new Attribute(
            get: fn ($value): bool => $this->status->equals(Current::class)
        );
    }

    public function isCurrent(): Attribute
    {
        return new Attribute(
            get: fn ($value): bool => $this->status->equals(Current::class)
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
        $this->addMediaCollection('story-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->parent($this->parent_id);
    }

    public function nextSibling(): self
    {
        return $this->getSibling('next');
    }

    public function previousSibling(): self
    {
        return $this->getSibling('previous');
    }

    protected function getSibling($direction)
    {
        $query = self::query()->parent($this->parent_id);

        return match ($direction) {
            'previous' => $query->where('order_column', $this->order_column--)->first(),
            'next' => $query->where('order_column', $this->order_column++)->first(),
            default => $query->first(),
        };
    }

    public static function getMediaPath(): string
    {
        return 'stories/{model_id}/{media_id}/';
    }
}
