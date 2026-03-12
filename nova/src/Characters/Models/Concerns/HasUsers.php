<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\CharacterUser;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\User;

trait HasUsers
{
    public function activeUsers(): BelongsToMany
    {
        return $this->users()
            ->whereState('status', Active::class);
    }

    public function activePrimaryUsers(): BelongsToMany
    {
        return $this->activeUsers()
            ->wherePivot('primary', true);
    }

    public function primaryUsers(): BelongsToMany
    {
        return $this->users()
            ->wherePivot('primary', true);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('primary')
            ->withTrashed()
            ->withTimestamps()
            ->using(CharacterUser::class);
    }
}
