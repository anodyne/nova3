<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Posts\Models\Post;
use Nova\Stories\Events;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\StoryStatus;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;

class Story extends Model implements HasMedia
{
    use HasFactory;
    use HasStates;
    use InteractsWithMedia;

    public const MEDIA_DIRECTORY = 'stories/{model_id}/{media_id}/';

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'start_date',
        'end_date', 'sort',
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'parent_id' => 'integer',
        'start_date' => 'datetime',
        'status' => StoryStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\StoryCreated::class,
        'deleted' => Events\StoryDeleted::class,
        'updated' => Events\StoryUpdated::class,
    ];

    public function allPosts()
    {
        return $this->hasMany(Post::class, 'story_id')->orderBy('sort');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'story_id')
            ->wherePublished()
            ->orderBy('sort');
    }

    public function stories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function allStoriesPostCount(): Attribute
    {
        return new Attribute(
            get: function ($value): int {
                if ($this->getDescendantCount() > 0) {
                    return Story::descendantsAndSelf($this->id)->sum('postCount');
                }

                return 0;
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

    // public function isMainTimeline(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value): bool => $this->id === 1
    //     );
    // }

    public function postCount(): Attribute
    {
        return new Attribute(
            get: fn ($value): int => $this->posts()->wherePublished()->count()
        );
    }

    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('story-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }

    public function previousSibling(): ?self
    {
        return self::query()
            ->where('parent_id', $this->parent_id)
            ->where('sort', '<', $this->sort)
            ->first();
    }

    public function nextSibling(): ?self
    {
        return self::query()
            ->where('parent_id', $this->parent_id)
            ->where('sort', '>', $this->sort)
            ->first();
    }
}
