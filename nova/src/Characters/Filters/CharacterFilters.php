<?php

declare(strict_types=1);

namespace Nova\Characters\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class CharacterFilters extends Filters
{
    protected array $filters = [
        'search', 'status', 'type', 'hasuser', 'nouser', 'noposition',
    ];

    public function hasuser($value): Builder
    {
        return $this->builder->whereHas('users');
    }

    public function noposition($value): Builder
    {
        return $this->builder->whereDoesntHave('positions');
    }

    public function nouser($value): Builder
    {
        return $this->builder->whereDoesntHave('users');
    }

    public function search($value): Builder
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
                return $query->where('name', 'like', "%{$value}%");
            })
            ->when(auth()->user()->isAbleTo('character.*'), function ($query) use ($value) {
                return $query->orWhereHas('users', function ($q) use ($value) {
                    return $q->where('email', 'like', "%{$value}%");
                });
            });
    }

    public function status($value): Builder
    {
        return $this->builder->whereState('status', $value);
    }

    public function type($value): Builder
    {
        return $this->builder->whereState('type', $value);
    }
}
