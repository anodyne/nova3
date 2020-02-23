<?php

namespace Nova\Notes\Events;

use Nova\Notes\Models\Note;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NoteDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public $note;

    public $originalNote;

    public function __construct(Note $note, Note $originalNote)
    {
        $this->note = $note;
        $this->originalNote = $originalNote;
    }
}
