<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\MapOutputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Illuminate\Http\Request;
use Nova\Stories\Models\Story;

/**
 * @method static static from(string $title, ?string $description, ?string $startedAt, ?string $endedAt, ?int $parentId, ?string $summary)
 */
#[MapInputName(SnakeCase::class)]
#[MapOutputName(SnakeCase::class)]
readonly class StoryData extends Bag
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $startedAt = null,
        public ?string $endedAt = null,
        public ?int $parentId = null,
        public ?string $summary = null
    ) {}

    public function parentStory(): ?Story
    {
        return Story::find($this->parentId);
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'started_at' => $request->input('started_at'),
            'ended_at' => $request->input('ended_at'),
            'parent_id' => $request->input('parent_id'),
            'summary' => $request->input('summary'),
        ];
    }
}
