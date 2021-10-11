<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\DataTable;

trait WithSorting
{
    public $sorts = [];

    public function sortBy($field): string
    {
        if (! isset($this->sorts[$field])) {
            return $this->sorts[$field] = 'asc';
        }

        if ($this->sorts[$field] === 'asc') {
            return $this->sorts[$field] = 'desc';
        }

        unset($this->sorts[$field]);
    }

    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
