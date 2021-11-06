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
    protected string $name = 'View Note';

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
            ->whereAuthor(auth()->user())
            ->searchFor($query)
            ->get()
            ->map(function ($note) {
                return new SpotlightSearchResult(
                    $note->id,
                    $note->title,
                    sprintf('View %s note', $note->title)
                );
            });
    }

    public function execute(Spotlight $spotlight, Note $note): void
    {
        $spotlight->redirectRoute('notes.show', $note);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new Note());
    }
}
