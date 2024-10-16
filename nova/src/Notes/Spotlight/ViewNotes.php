<?php

declare(strict_types=1);

namespace Nova\Notes\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Notes\Models\Note;

class ViewNotes extends SpotlightCommand
{
    protected string $name = 'View all my notes';

    protected string $description = 'View all my notes';

    protected array $synonyms = [
        'show notes',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.notes.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Note::class);
    }
}
