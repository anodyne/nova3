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

class ViewNote extends SpotlightCommand
{
    protected string $name = 'View a note';

    protected string $description = 'View a note';

    protected array $synonyms = [
        'show note',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('note')
                    ->setPlaceholder('Which note do you want to view?')
            );
    }

    public function searchNote($query)
    {
        return Note::query()
            ->currentUser()
            ->searchFor($query)
            ->get()
            ->map(
                fn (Note $note): SpotlightSearchResult => new SpotlightSearchResult(
                    $note->id,
                    $note->title,
                    sprintf('View %s note', $note->title)
                )
            );
    }

    public function execute(Spotlight $spotlight, Note $note): void
    {
        $spotlight->redirectRoute('admin.notes.show', $note);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new Note);
    }
}
