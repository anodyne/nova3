<?php

declare(strict_types=1);

namespace Nova\Posts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\Character;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Posts\Data\PostData;
use Nova\Posts\Events;
use Nova\Posts\Models\Builders\PostBuilder;
use Nova\Posts\Models\States\PostStatus;
use Nova\Posts\Models\States\Started;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;
use Spatie\EloquentSortable\Sortable;
use Spatie\LaravelData\WithData;
use Spatie\ModelStates\HasStates;

class Post extends Model implements Sortable
{
    use HasFactory;
    use HasStates;
    use WithData;
    use SortableTrait;

    protected $table = 'posts';

    protected $fillable = [
        'story_id', 'post_type_id', 'title', 'content', 'status', 'word_count',
        'day', 'time', 'location', 'parent_id', 'rating_language', 'rating_sex',
        'rating_violence', 'summary', 'participants', 'neighbor', 'direction',
        'sort',
    ];

    protected $casts = [
        'participants' => 'array',
        'published_at' => 'datetime',
        'rating_language' => 'integer',
        'rating_sex' => 'integer',
        'rating_violence' => 'integer',
        'status' => PostStatus::class,
    ];

    protected $dispatchesEvents = [
        'creating' => Events\PostCreating::class,
        'created' => Events\PostCreated::class,
        'deleted' => Events\PostDeleted::class,
        'saved' => Events\PostSaved::class,
        'saving' => Events\PostSaving::class,
        'updated' => Events\PostUpdated::class,
    ];

    protected $dataClass = PostData::class;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => false,
    ];

    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_author')
            ->wherePivot('post_id', $this->id)
            ->groupBy('pivot_user_id', 'pivot_post_id');
    }

    public function characterAuthors()
    {
        return $this->morphedByMany(Character::class, 'authorable', 'post_author')
            ->withPivot('user_id');
    }

    public function userAuthors()
    {
        return $this->morphedByMany(User::class, 'authorable', 'post_author')
            ->withPivot(['as', 'user_id']);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class)
            ->withTrashed();
    }

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    public function addParticipant(User $user): void
    {
        $participants = collect($this->participants)
            ->filter()
            ->push($user->id)
            ->unique()
            ->all();

        $this->fill(['participants' => $participants])->save();
    }

    public function removeParticipant(User $user): void
    {
        $this->characterAuthors()->wherePivot('user_id', $user->id)->detach();

        $this->userAuthors()->wherePivot('user_id', $user->id)->detach();

        $participants = collect($this->participants)
            ->filter()
            ->filter(fn ($participant) => $participant !== $user->id)
            ->unique()
            ->all();

        $this->fill(['participants' => $participants])->save();
    }

    public function shouldShowContentWarning(): bool
    {
        return $this->rating_language >= 2
            || $this->rating_sex >= 2
            || $this->rating_violence >= 2;
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->story($this->story_id)
            ->whereNotState('status', Started::class);
    }

    public function nextSibling($status = null): ?self
    {
        return $this->getSibling('next', $status);
    }

    public function previousSibling($status = null): ?self
    {
        return $this->getSibling('previous', $status);
    }

    protected function getSibling($direction, $status)
    {
        $query = self::query()
            ->story($this->story_id)
            ->when($status, fn (Builder $query) => $query->whereState('status', $status));

        $order = $this->order_column;

        return match ($direction) {
            'previous' => $query->where('order_column', $order - 1)->first(),
            'next' => $query->where('order_column', $order + 1)->first(),
            default => $query->first(),
        };
    }
}
