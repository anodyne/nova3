<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Notes\Models\Note;

class DuplicateNote extends Action
{
    public function handle(Note $original): Note
    {
        $note = $original->replicate(['prefixed_id']);
        $note->title = "Copy of {$note->title}";
        $note->save();

        $note->refresh();

        activity()
            ->performedOn($original)
            ->withProperty('replica', $note->id)
            ->event('duplicated')
            ->log('duplicated');

        return $note;
    }
}
