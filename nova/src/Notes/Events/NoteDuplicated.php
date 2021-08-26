<?php

declare(strict_types=1);

namespace Nova\Notes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Notes\Models\Note;

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
