<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Models\Note;

class UpdateNote
{
    public function execute(Note $note, NoteData $data): Note
    {
        return tap($note)
            ->update($data->except('user_id')->toArray())
            ->refresh();
    }
}
