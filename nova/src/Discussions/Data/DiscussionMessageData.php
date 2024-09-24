<?php

declare(strict_types=1);

namespace Nova\Discussions\Data;

use Nova\Discussions\Enums\MessageType;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class DiscussionMessageData extends Data
{
    public function __construct(
        #[MapOutputName('user_id')]
        public ?int $userId,

        public string $content,

        public MessageType $type
    ) {}
}
