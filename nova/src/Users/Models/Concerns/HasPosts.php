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

trait HasPosts
{
    public function draftPosts(): BelongsToMany
    {
        return $this->posts()->draft();
    }

    public function draftPostsNeedingAttention(): BelongsToMany
    {
        return $this->draftPosts()
            ->where(function (Builder $query): Builder {
                return $query->whereNull('last_update_by')
                    ->orWhere('last_update_by', '!=', Auth::id());
            });
    }

    public function latestPost(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author')
            ->published()
            ->latest('published_at')
            ->limit(1);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author');
    }

    public function postsAsUser(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    public function postAuthors(): HasMany
    {
        return $this->hasMany(PostAuthor::class);
    }

    public function publishedPosts(): BelongsToMany
    {
        return $this->posts()->published();
    }
}
