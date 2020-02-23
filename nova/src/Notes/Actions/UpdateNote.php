<?php

namespace Nova\Notes\Actions;

use Nova\Foundation\Action;
use Nova\Notes\Models\Note;
use Nova\Notes\DataTransferObjects\NoteData;

class UpdateNote extends Action
{
    public $errorMessage = 'There was a problem updating the note';

    public function execute(Note $note, NoteData $data): Note
    {
        return $this->call(function () use ($note, $data) {
            $note->update($data->except('user_id')->toArray());

            return $note->refresh();
        });
    }
}
