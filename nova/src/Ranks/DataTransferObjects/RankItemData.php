<?php

declare(strict_types=1);

namespace Nova\Ranks\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RankItemData extends DataTransferObject
{
    public string $base_image;

    public ?string $overlay_image;

    public ?int $group_id;

    public ?int $name_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'base_image' => $request->input('base_image'),
            'group_id' => (int) $request->group_id,
            'name_id' => (int) $request->name_id,
            'overlay_image' => $request->input('overlay_image'),
        ]);
    }
}
