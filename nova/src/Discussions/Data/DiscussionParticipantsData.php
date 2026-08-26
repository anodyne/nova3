<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Bag\Bag;

/**
 * @method static static from(string $sender, list<string> $recipients)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class DiscussionParticipantsData extends Bag
{
    /** @param list<string> $recipients */
    public function __construct(
        public string $sender,
        public array $recipients
    ) {}

    public function totalParticipants(): int
    {
        return count($this->recipients) + 1;
    }
}
