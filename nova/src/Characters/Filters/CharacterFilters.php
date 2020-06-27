<?php

namespace Nova\Characters\Filters;

use Nova\Foundation\Filters\Filters;
use Nova\Characters\Models\Character;

class CharacterFilters extends Filters
{
    protected $filters = ['search', 'status'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }

    public function status($value)
    {
        return $this->builder->whereState(
            'status',
            Character::getStatesFor('status')
                ->filter(function ($status) use ($value) {
                    return get_class_name($status) === ucfirst($value);
                })
                ->first()
        );
    }
}
