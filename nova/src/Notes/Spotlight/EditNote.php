<?php

declare(strict_types=1);

namespace Nova\Notes\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Notes\Models\Note;

class EditNote extends SpotlightCommand
{
    protected string $name = 'Edit a note';

    protected string $description = 'Edit one of my existing notes';

    protected array $synonyms = [
        'update note',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('note')
                    ->setPlaceholder('Which note do you want to edit?')
            );
    }

    public function searchNote($query)
    {
        return Note::query()
            ->currentUser()
            ->searchFor($query)
            ->get()
            ->map(function (Note $note) {
                return new SpotlightSearchResult(
                    $note->id,
                    $note->title,
                    sprintf('Edit %s note', $note->title)
                );
            });
    }

    public function execute(Spotlight $spotlight, Note $note): void
    {
        $spotlight->redirectRoute('notes.edit', $note);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Note());
    }
}
