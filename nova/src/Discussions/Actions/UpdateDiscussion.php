<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;

class UpdateDiscussion
{
    use AsAction;

    public function handle(Discussion $discussion, DiscussionData $data): Discussion
    {
        $discussion->update(
            Arr::except($data->toArray(), ['message', 'participants'])
        );

        return $discussion->refresh();
    }
}
