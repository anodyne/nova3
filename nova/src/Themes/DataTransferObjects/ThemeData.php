<?php

namespace Nova\Themes\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ThemeData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $location;

    /**
     * @var  string
     */
    public $credits;

    /**
     * @var  bool
     */
    public $active;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
            'location' => $request->location,
            'credits' => $request->credits,
            'active' => $request->active ?? true,
        ]);
    }
}
