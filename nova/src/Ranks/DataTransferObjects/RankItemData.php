<?php

namespace Nova\Ranks\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RankItemData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $base_image;

    /**
     * @var  string
     */
    public $overlay_image;

    /**
     * @var  int
     */
    public $group_id;

    /**
     * @var  int
     */
    public $name_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'base_image' => $request->input('base_image'),
            'overlay_image' => $request->input('overlay_image'),
            'group_id' => $request->group_id,
            'name_id' => $request->name_id,
        ]);
    }
}
