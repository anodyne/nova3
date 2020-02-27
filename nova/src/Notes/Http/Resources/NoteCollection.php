<?php

namespace Nova\Notes\Http\Resources;

use Nova\Foundation\Http\Resources\ResourceCollection;

class NoteCollection extends ResourceCollection
{
    public $collects = NoteResource::class;

    public function toArray($request)
    {
        return $this->paginateResources([]);
    }
}
