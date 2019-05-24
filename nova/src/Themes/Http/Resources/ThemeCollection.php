<?php

namespace Nova\Themes\Http\Resources;

use Nova\Themes\Models\Theme;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ThemeCollection extends ResourceCollection
{
    public $collects = ThemeResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();

        return [
            'can' => [
                'create' => gate()->allows('create', Theme::class),
                'delete' => gate()->allows('delete', Theme::class),
                'update' => gate()->allows('update', Theme::class),
            ],
            'data' => $this->collection,
        ];
    }
}
