<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;

/**
 * @extends Builder<PostAuthor>
 */
class PostAuthorBuilder extends Builder
{
    public function draft(): self
    {
        return $this->whereRelation('post', Post::column('status'), '=', 'draft');
    }

    public function includedInPostTracking(): self
    {
        return $this->whereRelation('post.postType', 'options->includedInPostTracking', '=', true);
    }

    public function published(): self
    {
        return $this->whereRelation('post', Post::column('status'), '=', 'published');
    }

    public function timeframe(?CarbonInterface $start = null, ?CarbonInterface $end = null): self
    {
        return $this
            ->when(filled($start), fn (Builder $query): Builder => $query->where('updated_at', '>=', $start))
            ->when(filled($end), fn (Builder $query): Builder => $query->where('updated_at', '<=', $end));
    }

    public function updatedBetween(?CarbonInterface $start = null, ?CarbonInterface $end = null): self
    {
        return $this->whereBetween('updated_at', [$start, $end]);
    }

    public function wherePost(int|Post|null $post): self
    {
        if ($post === null) {
            return $this;
        }

        return $this->where('post_id', $post instanceof Post ? $post->id : $post);
    }

    public function whereUser(int|User $user): self
    {
        return $this->where('user_id', $user->id ?? $user);
    }
}
