<?php

namespace Nova\Foundation\Models\Concerns;

trait Sortable
{
    public function orderBySort()
    {
        return $this->orderBy('sort', 'asc');
    }
}
