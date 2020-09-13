<?php

namespace Nova\Posts\Models;

use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Illuminate\Database\Eloquent\Model;
use Nova\Posts\Models\States\Published;
use Nova\Posts\Models\States\PostStatus;
use Nova\Posts\Models\States\DraftToPending;
use Nova\Posts\Models\States\DraftToPublished;
use Nova\Posts\Models\States\PendingToPublished;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStates\HasStates;
use Nova\Posts\Events;

class Post extends Model
{
    use HasFactory;
    use HasStates;

    protected $table = 'posts';

    protected $fillable = [
        'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
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
        return $this->belongsTo(PostType::class);
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
