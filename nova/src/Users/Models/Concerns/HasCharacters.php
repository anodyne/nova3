<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterUser;

trait HasCharacters
{
    /**
     * @return BelongsToMany<Character, $this, CharacterUser, 'pivot'>
     */
    public function activeCharacters(): BelongsToMany
    {
        return $this->characters()->active();
    }

    /**
     * @return BelongsToMany<Character, $this, CharacterUser, 'pivot'>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)
            ->withPivot('primary')
            ->withTimestamps()
            ->using(CharacterUser::class);
    }

    /**
     * @return BelongsToMany<Character, $this, CharacterUser, 'pivot'>
     */
    public function primaryCharacter(): BelongsToMany
    {
        return $this->activeCharacters()->wherePivot('primary', true);
    }
}
