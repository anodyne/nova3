<?php

declare(strict_types=1);

namespace Nova\Notes\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Notes\Models\Note;

class NoteUpdated
{
    use Dispatchable;
    use SerializesModels;

    public $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }
}
