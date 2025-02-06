<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Bag\Bag;

/**
 * @method static static from(?string $subject, DiscussionMessageData $message, DiscussionParticipantsData $participants)
 */
readonly class DiscussionData extends Bag
{
    public function __construct(
        public ?string $subject,
        public DiscussionMessageData $message,
        public DiscussionParticipantsData $participants
    ) {}
}
