<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;

class UpdateNote extends Action
{
    public function handle(Note $note, NoteData $data): Note
    {
        return tap($note)
            ->update($data->toArray())
            ->refresh();
    }
}
