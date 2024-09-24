<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class DiscussionData extends Data
{
    public function __construct(
        public ?string $name,

        #[MapOutputName('is_direct_message')]
        public bool $isDirectMessage,

        #[MapOutputName('direct_message_participants')]
        public ?array $directMessageParticipants,

        public DiscussionMessageData $message,
        public DiscussionParticipantsData $participants
    ) {}
}
