<?php

namespace Nova\Notes\Events;

use Nova\Notes\Models\Note;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NoteDeleted
{
    use Dispatchable;
    use SerializesModels;

    public $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
