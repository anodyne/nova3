<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Spatie\LaravelData\Data;

class DiscussionData extends Data
{
    public function __construct(
        public ?string $name,
        public DiscussionMessageData $message,
        public DiscussionParticipantsData $participants
    ) {}
}
