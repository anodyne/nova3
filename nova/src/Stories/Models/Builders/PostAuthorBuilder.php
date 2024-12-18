<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class PostAuthorBuilder extends Builder
{
    public function timeframe(?CarbonInterface $start = null, ?CarbonInterface $end = null): self
    {
        return $this
            ->when(filled($start), fn (Builder $query): Builder => $query->where('updated_at', '>=', $start))
            ->when(filled($end), fn (Builder $query): Builder => $query->where('updated_at', '<=', $end));
    }

    public function wherePost(int|Post $post): self
    {
        return $this->where('post_id', $post?->id);
    }

    public function whereUser(int|User $user): self
    {
        return $this->where('user_id', $user?->id);
    }
}
