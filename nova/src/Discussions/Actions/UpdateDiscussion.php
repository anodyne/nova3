<?php

declare(strict_types=1);

namespace Nova\Discussions\Actions;

use Illuminate\Support\Arr;
use Nova\Discussions\Data\DiscussionData;
use Nova\Discussions\Models\Discussion;
use Nova\Foundation\Actions\Action;

class UpdateDiscussion extends Action
{
    public function handle(Discussion $discussion, DiscussionData $data): Discussion
    {
        $discussion->update(
            Arr::except($data->toArray(), ['message', 'participants'])
        );

        return $discussion->refresh();
    }
}
