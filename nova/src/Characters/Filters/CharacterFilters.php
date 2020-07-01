<?php

namespace Nova\Characters\Filters;

use Nova\Foundation\Filters\Filters;
use Nova\Characters\Models\Character;

class CharacterFilters extends Filters
{
    protected $filters = ['search', 'status', 'type', 'hasuser', 'nouser'];

    public function hasuser($value)
    {
        return $this->builder->whereHas('user');
    }

    public function nouser($value)
    {
        return $this->builder->whereDoesntHave('user');
    }

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

    public function type($value)
    {
        return $this->builder->whereState(
            'type',
            Character::getStatesFor('type')
                ->filter(function ($type) use ($value) {
                    return get_class_name($type) === ucfirst($value);
                })
                ->first()
        );
    }
}
