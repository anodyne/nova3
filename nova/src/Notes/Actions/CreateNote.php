<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;

class CreateNote extends Action
{
    public function handle(NoteData $data): Note
    {
        return $data->user()->notes()->create($data->toArray());
    }
}
