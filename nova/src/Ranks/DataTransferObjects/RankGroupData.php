<?php

namespace Nova\Ranks\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RankGroupData extends DataTransferObject
{
    public string $name;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
        ]);
    }
}
