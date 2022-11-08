<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Notes\Models\Note;

class DuplicateNote
{
    use AsAction;

    public function handle(Note $original): Note
    {
        $note = $original->replicate();
        $note->title = "Copy of {$note->title}";
        $note->save();

        return $note->refresh();
    }
}
