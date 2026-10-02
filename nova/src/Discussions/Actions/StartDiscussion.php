<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Events\DiscussionStarted;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class StartDiscussion extends Action
{
    public function handle(DiscussionData $data): Discussion
    {
        return DB::transaction(function () use ($data) {
            $discussion = Discussion::create(
                Arr::except($data->toArray(), ['message', 'participants'])
            );

            $discussion = AddParticipantsToDiscussion::run($discussion, $data->participants);

            SendMessage::run($discussion, $data);

            DiscussionStarted::dispatch($discussion);

            return $discussion;
        });
    }
}
