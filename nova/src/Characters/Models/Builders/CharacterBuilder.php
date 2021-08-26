<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Inactive;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Foundation\Filters\Filterable;

class CharacterBuilder extends Builder
{
    use Filterable;

    public function whereActive()
    {
        return $this->where('status', Active::class);
    }

    public function whereInactive()
    {
        return $this->where('state', Inactive::class);
    }

    public function whereIsPrimaryCharacter()
    {
        return $this->join('character_user', 'character_user.character_id', '=', 'characters.id')
            ->where('character_user.primary', true);
    }

    public function wherePending()
    {
        return $this->where('state', Pending::class);
    }
}
