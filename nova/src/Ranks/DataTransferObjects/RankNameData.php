<?php

namespace Nova\Ranks\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RankNameData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->input('name'),
        ]);
    }
}
