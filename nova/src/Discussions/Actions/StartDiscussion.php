<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Events\DiscussionStarted;
use Nova\Discussions\Models\Discussion;
use Throwable;

class StartDiscussion
{
    use AsAction;

    public function handle(DiscussionData $data): Discussion
    {
        VerifyDirectMessageParticipantCount::runIf($data->isDirectMessage, $data);

        $discussion = FindExistingDiscussionWithParticipants::run($data);

        if (filled($discussion)) {
            SendMessage::run($discussion, $data);

            return $discussion->refresh();
        } else {
            DB::beginTransaction();

            try {
                $discussion = Discussion::create(
                    $data->except('message', 'participants')->all()
                );

                $discussion = AddParticipantsToDiscussion::run($discussion, $data->participants);

                SendMessage::run($discussion, $data);

                DB::commit();

                DiscussionStarted::dispatch($discussion);

                return $discussion;
            } catch (Throwable $th) {
                DB::rollBack();

                throw $th;
            }
        }
    }
}
