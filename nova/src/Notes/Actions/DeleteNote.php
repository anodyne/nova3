<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Notes\Models\Note;

class DeleteNote
{
    public function execute(Note $note): Note
    {
        return tap($note)->delete();
    }
}
