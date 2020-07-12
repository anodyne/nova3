<?php

namespace Nova\Themes\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ThemeData extends DataTransferObject
{
    public string $name;

    public string $location;

    public ?string $credits;

    public bool $active = true;

    public ?string $preview;

    public ?array $variants;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'active' => (bool) ($request->active ?? true),
            'credits' => $request->credits,
            'location' => $request->location,
            'name' => $request->name,
            'preview' => $request->preview,
            'variants' => explode(',', $request->input('variants')),
        ]);
    }
}
