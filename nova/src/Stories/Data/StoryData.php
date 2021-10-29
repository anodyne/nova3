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
        public bool $allow_posting,
        public ?string $start_date,
        public ?string $end_date,
        public ?int $parent_id,
        public Story $parent,
        public ?string $summary
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->input('title'),
            description: $request->input('description'),
            allow_posting: (bool) $request->input('allow_posting'),
            start_date: $request->input('start_date'),
            end_date: $request->input('end_date'),
            parent_id: (int) $request->input('parent_id'),
            parent: ($id = $request->input('parent_id')) ? Story::find($id) : Story::first(),
            summary: $request->input('summary')
        );
    }
}
