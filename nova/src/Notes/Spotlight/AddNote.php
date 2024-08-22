<?php

declare(strict_types=1);

namespace Nova\Notes\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Notes\Models\Note;

class AddNote extends SpotlightCommand
{
    protected string $name = 'Add a note';

    protected string $description = 'Add a new note';

    protected array $synonyms = [
        'create note',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.notes.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Note::class);
    }
}
