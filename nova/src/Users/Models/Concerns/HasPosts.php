<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Published;

trait HasPosts
{
    /**
     * @return BelongsToMany<Post, $this>
     */
    public function draftPosts(): BelongsToMany
    {
        $relation = $this->posts();

        $relation->whereState('status', Draft::class);

        return $relation;
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function draftPostsNeedingAttention(): BelongsToMany
    {
        return $this->draftPosts()
            ->where(fn (Builder $query): Builder => $query->whereNull('last_update_by')
                ->orWhere('last_update_by', '!=', Auth::id()));
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function latestPost(): BelongsToMany
    {
        $relation = $this->posts();

        $relation->whereState('status', Published::class);

        return $relation
            ->latest('published_at')
            ->limit(1);
    }

    /**
     * @return HasMany<PostAuthor, $this>
     */
    public function postAuthors(): HasMany
    {
        return $this->hasMany(PostAuthor::class);
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author');
    }

    /**
     * @return MorphToMany<Post, $this>
     */
    public function postsAsUser(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    /**
     * @return BelongsToMany<Post, $this>
     */
    public function publishedPosts(): BelongsToMany
    {
        $relation = $this->posts();

        $relation->whereState('status', Published::class);

        return $relation;
    }
}
