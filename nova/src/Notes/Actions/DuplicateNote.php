<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Notes\Models\Note;

class DuplicateNote
{
    public function execute(Note $originalNote): Note
    {
        $note = $originalNote->replicate();

        $note->title = "Copy of {$note->title}";

        $note->save();

        return $note->refresh();
    }
}
