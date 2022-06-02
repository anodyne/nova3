<?php

declare(strict_types=1);

namespace Nova\Posts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Nova\Posts\Data\PostData;
use Nova\Posts\Events;
use Nova\Posts\Models\Builders\PostBuilder;
use Nova\Posts\Models\States\PostStatus;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Spatie\LaravelData\WithData;
use Spatie\ModelStates\HasStates;

class Post extends Model
{
    use HasFactory;
    use HasStates;
    use NodeTrait;
    use WithData;

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
        'status' => PostStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PostCreated::class,
        'deleted' => Events\PostDeleted::class,
        'updated' => Events\PostUpdated::class,
    ];

    protected $dataClass = PostData::class;

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
        return $this->belongsTo(PostType::class, 'post_type_id')
            ->withTrashed();
    }

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    public function shouldShowContentWarning(): bool
    {
        return $this->rating_language >= 2
            || $this->rating_sex >= 2
            || $this->rating_violence >= 2;
    }
}
