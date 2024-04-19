<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class FormBuilder extends Builder
{
    public function searchFor($search): Builder
    {
        return $this->whereAny([
            'name',
            'key',
            'description',
        ], 'like', "%{$search}%");
    }
}
