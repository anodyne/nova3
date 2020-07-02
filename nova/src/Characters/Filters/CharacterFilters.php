<?php

namespace Nova\Characters\Filters;

use Nova\Foundation\Filters\Filters;
use Nova\Characters\Models\Character;

class CharacterFilters extends Filters
{
    protected $filters = ['search', 'status', 'type', 'hasuser', 'nouser'];

    public function hasuser($value)
    {
        return $this->builder->whereHas('users');
    }

    public function nouser($value)
    {
        return $this->builder->whereDoesntHave('users');
    }

    public function search($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('positions', function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('positions.department', function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('users', function ($query) use ($value) {
                return $query->where(function ($q) use ($value) {
                    return $q->where('name', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                });
            });
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
                    return strtolower(get_class_name($type)) === strtolower($value);
                })
                ->first()
        );
    }
}
