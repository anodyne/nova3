<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Forms\Models\Form;

class FormsList extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $search;

    public function getFilteredFormsProperty()
    {
        $forms = Form::query()
            ->when($this->search, fn ($query, $value) => $query->searchFor($value));

        return $forms->paginate();
    }

    public function render()
    {
        return view('livewire.forms.forms-list', [
            'formClass' => Form::class,
            'formCount' => Form::count(),
            'forms' => $this->filteredForms,
        ]);
    }
}
