<?php

namespace Nova\Characters\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Statuses\Inactive;

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
