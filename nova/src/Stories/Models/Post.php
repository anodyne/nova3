<?php

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Stories\Models\States\Posts\Draft;
use Nova\Stories\Models\States\Posts\Pending;
use Nova\Stories\Models\States\Posts\Published;
use Nova\Stories\Models\States\Posts\PostStatus;
use Nova\Stories\Models\States\Posts\DraftToPending;
use Nova\Stories\Models\States\Posts\DraftToPublished;
use Nova\Stories\Models\States\Posts\PendingToPublished;

class Post extends Model
{
    protected $table = 'posts';

    protected $casts = [
        'published_at' => 'datetime',
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
