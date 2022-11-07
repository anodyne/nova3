<?php

declare(strict_types=1);

namespace Nova\Notes\Livewire;

use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\Concerns\WithConfirmationModal;
use Nova\Notes\Models\Note;

class NotesList extends Component
{
    use HasFilters;
    use WithConfirmationModal;
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

    public function delete($id): void
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $note = Note::find($id);

        $this->askForConfirmation(
            callback: fn () => Note::find($note->id)?->delete(),
            prompt: [
                'title' => 'Delete note?',
                'message' => "Are you sure you want to delete your <span class=\"font-semibold\">{$note->title}</span> note? This action is permanent and cannot be undone.",
                'confirm' => 'Delete',
            ],
            theme: 'error',
        );
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
            'noteCount' => Note::whereAuthor(auth()->user())->count(),
        ]);
    }
}
