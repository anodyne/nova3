<?php

declare(strict_types=1);

namespace Nova\Ranks\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RankNameData extends DataTransferObject
{
    public string $name;

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
        );
    }
}
