<?php

declare(strict_types=1);

namespace Nova\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Nova\Posts\Events;
use Nova\Posts\Models\Builders\PostBuilder;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\DraftToPending;
use Nova\Posts\Models\States\DraftToPublished;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\PendingToPublished;
use Nova\Posts\Models\States\PostStatus;
use Nova\Posts\Models\States\Published;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Spatie\ModelStates\HasStates;

class Post extends Model
{
    use HasFactory;
    use HasStates;
    use NodeTrait;

    protected $table = 'posts';

    protected $fillable = [
        'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count',
        'day', 'time', 'location', 'parent_id', 'rating_language', 'rating_sex',
        'rating_violence',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'rating_language' => 'integer',
        'rating_sex' => 'integer',
        'rating_violence' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\PostCreated::class,
        'deleted' => Events\PostDeleted::class,
        'updated' => Events\PostUpdated::class,
    ];

    public function authorable()
    {
        return $this->morphTo();
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function type()
    {
        return $this->belongsTo(PostType::class, 'post_type_id');
    }

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    protected function registerStates(): void
    {
        $this->addState('status', PostStatus::class)
            ->allowTransitions([
                [Draft::class, Pending::class, DraftToPending::class],
                [Draft::class, Published::class, DraftToPublished::class],
                [Pending::class, Published::class, PendingToPublished::class],
            ])
            ->default(Draft::class);
    }
}
