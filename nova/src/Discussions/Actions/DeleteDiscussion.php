<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\Discussion;

class DeleteDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion): void
    {
        DB::transaction(function () use ($discussion): void {
            $discussion->notifications()->delete();

            $discussion->messages()->delete();

            $discussion->allParticipants()->detach();

            $discussion->delete();
        });
    }
}
