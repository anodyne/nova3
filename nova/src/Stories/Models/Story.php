<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
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
    use NodeTrait;

    public const MEDIA_DIRECTORY = 'stories/{model_id}/{media_id}/';

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'start_date',
        'end_date', 'allow_posting',
    ];

    protected $casts = [
        'allow_posting' => 'boolean',
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
        return $this->hasMany(Post::class, 'story_id')->defaultOrder();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'story_id')
            ->wherePublished()
            ->defaultOrder();
    }

    public function rootPost()
    {
        return $this->hasOne(Post::class, 'story_id')->where('parent_id', null);
    }

    public function stories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getCanPostAttribute(): bool
    {
        return $this->status->equals(Current::class);
    }

    public function getPostCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function getAllStoriesPostCountAttribute(): int
    {
        if ($this->getDescendantCount() > 0) {
            return Story::withCount('posts')
                ->descendantsAndSelf($this->id)
                ->sum('posts_count');
        }

        return 0;
    }

    public function isMainTimeline(): bool
    {
        return $this->id === 1;
    }

    public function getIsCurrentAttribute(): bool
    {
        return $this->status->equals(Current::class);
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
}
