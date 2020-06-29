<?php

namespace Nova\Notes\Actions;

use Nova\Notes\Models\Note;
use Nova\Notes\DataTransferObjects\NoteData;

class CreateNote
{
    public function execute(NoteData $data): Note
    {
        return $data->user->notes()->create(
            $data->except('user_id')->toArray()
        );
    }
}
