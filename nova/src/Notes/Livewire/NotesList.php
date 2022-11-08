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

    public function filters(): array
    {
        $orderByFilter = Filter::make('order_by')
            ->options(['created' => 'Created', 'updated' => 'Updated'])
            ->default('updated')
            ->meta(['label' => 'Order by']);

        return [
            $orderByFilter,
        ];
    }

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
            ->when($this->getFilterValue('order_by') === 'created', fn ($query) => $query->orderBy('created_at', 'desc'))
            ->when($this->getFilterValue('order_by') === 'updated', fn ($query) => $query->orderBy('updated_at', 'desc'))
            ->latest()
            ->paginate();
    }

    public function render()
    {
        return view('livewire.notes.notes-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'notes' => $this->filteredNotes,
            'noteCount' => Note::whereAuthor(auth()->user())->count(),
        ]);
    }
}
