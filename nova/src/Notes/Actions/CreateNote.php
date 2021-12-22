<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;

class CreateNote
{
    use AsAction;

    public function handle(NoteData $data): Note
    {
        return $data->user->notes()->create(
            Arr::except($data->all(), 'user')
        );
    }
}
