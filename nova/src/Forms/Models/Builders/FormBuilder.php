<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Enums\FormStatus;

class FormBuilder extends Builder
{
    public function active(): Builder
    {
        return $this->where('status', FormStatus::Active);
    }

    public function key(string $key): Builder
    {
        return $this->where('key', $key);
    }

    public function searchFor($search): Builder
    {
        return $this->whereAny([
            'name',
            'key',
            'description',
        ], 'like', "%{$search}%");
    }
}
