<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;

class UpdateNote
{
    use AsAction;

    public function handle(Note $note, NoteData $data): Note
    {
        return tap($note)
            ->update(Arr::except($data->all(), 'user'))
            ->refresh();
    }
}
