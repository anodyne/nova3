<?php

namespace Nova\Themes\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'credits' => $this->credits,
            'id' => $this->id,
            'location' => $this->location,
            'name' => $this->name,
        ];
    }
}
