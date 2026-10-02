<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Notes\Models\Note;

class DeleteNote extends Action
{
    public function handle(Note $note): Note
    {
        return tap($note)->delete();
    }
}
