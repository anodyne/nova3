<?php

declare(strict_types=1);

namespace Nova\Notes\Livewire;

use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Notes\Models\Note;

class NotesList extends Component
{
    use HasFilters;
    use WithPagination;

    public $search;

    // public function filters(): array
    // {
    //     $orderByFilter = Filter::make('order_by')
    //         ->options(['Recently created', 'Recently updated'])
    //         ->default(['Recently updated'])
    //         ->meta(['label' => 'Order by']);

    //     return [
    //         $orderByFilter,
    //     ];
    // }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredNotesProperty()
    {
        return Note::whereAuthor(auth()->user())
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->latest()
            ->paginate();
    }

    public function render()
    {
        return view('livewire.notes.notes-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'notes' => $this->filteredNotes,
        ]);
    }
}
