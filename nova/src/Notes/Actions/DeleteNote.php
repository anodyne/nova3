<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Notes\Models\Note;

class DeleteNote
{
    use AsAction;

    public function handle(Note $note): Note
    {
        return tap($note)->delete();
    }
}
