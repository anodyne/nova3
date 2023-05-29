<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class FormBuilder extends Builder
{
    public function searchFor($search): Builder
    {
        return $this->where(function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('key', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
