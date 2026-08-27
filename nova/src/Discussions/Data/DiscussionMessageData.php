<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Bag\Attributes\MapOutputName;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Nova\Discussions\Enums\MessageType;

/**
 * @method static static from(?string $userId, string $content, MessageType $type)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class DiscussionMessageData extends Bag
{
    public function __construct(
        #[MapOutputName(SnakeCase::class)]
        public ?string $userId,

        public string $content,

        public MessageType $type
    ) {}
}
