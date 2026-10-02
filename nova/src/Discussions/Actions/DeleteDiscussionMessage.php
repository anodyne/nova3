<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Foundation\Actions\Action;

class DeleteDiscussionMessage extends Action
{
    public function handle(DiscussionMessage $message): void
    {
        DB::transaction(function () use ($message): void {
            $message->notifications()->delete();

            $message->delete();
        });
    }
}
