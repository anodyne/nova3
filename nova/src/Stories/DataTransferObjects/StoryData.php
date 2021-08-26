<?php

declare(strict_types=1);

namespace Nova\Stories\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class StoryData extends DataTransferObject
{
    public string $title;

    public ?string $description;

    public ?string $summary;

    public ?int $parent_id;

    public ?string $start_date;

    public ?string $end_date;

    public bool $allow_posting;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'allow_posting' => (bool) $request->allow_posting,
            'description' => $request->description,
            'end_date' => $request->end_date,
            'parent_id' => (int) $request->parent_id,
            'start_date' => $request->start_date,
            'summary' => $request->summary,
            'title' => $request->title,
        ]);
    }
}
