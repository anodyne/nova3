<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Spatie\LaravelData\Data;

class DiscussionParticipantsData extends Data
{
    public function __construct(
        public int $sender,
        public array $recipients
    ) {}

    public function totalParticipants(): int
    {
        return count($this->recipients) + 1;
    }
}
