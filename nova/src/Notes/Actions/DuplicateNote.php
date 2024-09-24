<?php

declare(strict_types=1);

namespace Nova\Notes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Notes\Models\Note;

class DuplicateNote
{
    use AsAction;

    public function handle(Note $original): Note
    {
        $replica = $original->replicate(['prefixed_id']);
        $replica->title = "Copy of {$replica->title}";
        $replica->save();

        return $replica->refresh();
    }
}
