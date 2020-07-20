<?php

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\States\Stories\Current;
use Nova\Stories\Models\States\Stories\Upcoming;
use Nova\Stories\Models\States\Stories\Completed;
use Nova\Stories\Models\States\Stories\StoryStatus;
use Nova\Stories\Models\States\Stories\UpcomingToCurrent;
use Nova\Stories\Models\States\Stories\CurrentToCompleted;
use Spatie\ModelStates\HasStates;

class Story extends Model
{
    use HasStates;

    protected $table = 'stories';

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function parentStory()
    {
        return $this->hasOne(self::class, 'story_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function stories()
    {
        return $this->hasMany(self::class, 'story_id');
    }

    protected function registerStates(): void
    {
        $this->addState('status', StoryStatus::class)
            ->allowTransitions([
                [Upcoming::class, Current::class, UpcomingToCurrent::class],
                [Current::class, Completed::class, CurrentToCompleted::class],
            ])
            ->default(Upcoming::class);
    }

    public function newEloquentBuilder($query): StoryBuilder
    {
        return new StoryBuilder($query);
    }
}
