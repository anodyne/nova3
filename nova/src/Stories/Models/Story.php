<?php

namespace Nova\Stories\Models;

use Nova\Stories\Events;
use Nova\Posts\Models\Post;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Model;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\StoryStatus;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\CurrentToUpcoming;
use Nova\Stories\Models\States\UpcomingToCurrent;
use Nova\Stories\Models\States\CurrentToCompleted;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Story extends Model implements HasMedia
{
    use HasMediaTrait;
    use HasStates;
    use NodeTrait;

    public const MEDIA_DIRECTORY = 'stories/{model_id}/{media_id}/';

    protected $table = 'stories';

    protected $fillable = [
        'title', 'status', 'parent_id', 'description', 'summary', 'start_date',
        'end_date',
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'parent_id' => 'integer',
        'start_date' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => Events\StoryCreated::class,
        'deleted' => Events\StoryDeleted::class,
        'updated' => Events\StoryUpdated::class,
    ];

    public function parentStory()
    {
        return $this->hasOne(self::class, 'story_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'story_id');
    }

    public function stories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('story-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    protected function registerStates(): void
    {
        $this->addState('status', StoryStatus::class)
            ->allowTransitions([
                [Upcoming::class, Current::class, UpcomingToCurrent::class],
                [Current::class, Upcoming::class, CurrentToUpcoming::class],
                [Current::class, Completed::class, CurrentToCompleted::class],
            ])
            ->default(Upcoming::class);
    }
}
