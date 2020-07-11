<?php

namespace Nova\Notes\Actions;

use Nova\Notes\Models\Note;
use Nova\Notes\DataTransferObjects\NoteData;

class UpdateNote
{
    public function execute(Note $note, NoteData $data): Note
    {
        return tap($note)
            ->update($data->except('user_id')->toArray())
            ->refresh();
    }
}
