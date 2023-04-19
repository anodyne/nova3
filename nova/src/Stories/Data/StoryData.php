<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Spatie\LaravelData\Data;

class StoryData extends Data
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $start_date,
        public ?string $end_date,
        public ?int $parent_id,
        public ?string $summary
    ) {
    }

    public function parent(): Story
    {
        return Story::findOrFail($this->parent_id);
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
            start_date: $request->input('start_date'),
            end_date: $request->input('end_date'),
            parent_id: $request->whenFilled('parent_id', fn ($value) => (int) $value, fn () => null),
            summary: $request->input('summary')
        );
    }
}
