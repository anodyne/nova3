<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Exceptions\TooManyDirectMessageParticipants;

class VerifyDirectMessageParticipantCount
{
    use AsAction;

    public function handle(DiscussionData $data): void
    {
        throw_if(
            $data->participants->totalParticipants() !== 2,
            TooManyDirectMessageParticipants::class
        );
    }
}
