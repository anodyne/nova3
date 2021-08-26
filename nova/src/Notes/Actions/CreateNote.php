<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Notes\Models\Note;

class CreateNote
{
    public function execute(NoteData $data): Note
    {
        return $data->user->notes()->create(
            $data->except('user_id')->toArray()
        );
    }
}
