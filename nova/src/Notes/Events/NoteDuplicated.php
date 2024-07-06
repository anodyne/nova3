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

    public function __construct(
        public Note $note,
        public Note $original
    ) {}
}
