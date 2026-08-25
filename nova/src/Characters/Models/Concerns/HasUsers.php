<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\CharacterUser;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\User;

trait HasUsers
{
    /**
     * @return BelongsToMany<User, $this, CharacterUser, 'pivot'>
     */
    public function activeUsers(): BelongsToMany
    {
        /** @var BelongsToMany<User, $this, CharacterUser, 'pivot'> $relation */
        $relation = $this->users()->whereState('status', Active::class);

        return $relation;
    }

    /**
     * @return BelongsToMany<User, $this, CharacterUser, 'pivot'>
     */
    public function activePrimaryUsers(): BelongsToMany
    {
        return $this->activeUsers()
            ->wherePivot('primary', true);
    }

    /**
     * @return BelongsToMany<User, $this, CharacterUser, 'pivot'>
     */
    public function primaryUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('primary', true);
    }

    /**
     * @return BelongsToMany<User, $this, CharacterUser, 'pivot'>
     */
    public function users(): BelongsToMany
    {
        /** @var BelongsToMany<User, $this, CharacterUser, 'pivot'> $relation */
        $relation = $this->belongsToMany(User::class)
            ->withPivot('primary')
            ->withTrashed()
            ->withTimestamps()
            ->using(CharacterUser::class);

        return $relation;
    }
}
