<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Bag\Bag;

/**
 * @method static static from(int $sender, array $recipients)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class DiscussionParticipantsData extends Bag
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
