<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Models\DiscussionMessage;

class DeleteDiscussionMessage
{
    use AsAction;

    public function handle(DiscussionMessage $message): void
    {
        $message->delete();
    }
}
