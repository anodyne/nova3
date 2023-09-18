<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Nova\Stories\Models\Story;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class StoryData extends Data
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $startedAt = null,
        public ?string $endedAt = null,
        public ?int $parentId = null,
        public ?string $summary = null
    ) {
    }

    public function parentStory(): Story
    {
        return Story::findOrFail($this->parentId);
    }
}
