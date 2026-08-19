<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\DiscussionMessage;

class DeleteDiscussionMessage
{
    use AsAction;

    public function handle(DiscussionMessage $message): void
    {
        DB::transaction(function () use ($message): void {
            $message->notifications()->delete();

            $message->delete();
        });
    }
}
