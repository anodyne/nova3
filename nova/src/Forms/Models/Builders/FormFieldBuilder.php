<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class FormFieldBuilder extends Builder
{
    public function uid(string $uid): Builder
    {
        return $this->where('uid', $uid);
    }
}
