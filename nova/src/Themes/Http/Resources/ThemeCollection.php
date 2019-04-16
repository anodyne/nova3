<?php

namespace Nova\Themes\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ThemeCollection extends ResourceCollection
{
    public $collects = ThemeResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth()->user();

        return [
            'can' => [
                'create' => $user->can('theme.create'),
                'delete' => $user->can('theme.delete'),
                'update' => $user->can('theme.update'),
            ],
            'data' => $this->collection
        ];
    }
}
