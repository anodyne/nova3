<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    public $perPage = 10;

    public $columns = ['*'];

    public $pageName = 'page';

    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    public function applyPagination($query, array $columns = ['*'], string $pageName = 'page')
    {
        return $query->paginate($this->perPage, $columns, $pageName);
    }
}
