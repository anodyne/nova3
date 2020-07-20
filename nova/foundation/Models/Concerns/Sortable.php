<?php

namespace Nova\Foundation\Models\Concerns;

trait Sortable
{
    public function orderBySort()
    {
        return $this->orderBy('sort', 'asc');
    }

    public function orderBySortDesc()
    {
        return $this->orderBy('sort', 'desc');
    }
}
