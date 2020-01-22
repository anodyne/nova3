<?php

namespace Nova\Foundation\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection as IlluminateResourceCollection;

class ResourceCollection extends IlluminateResourceCollection
{
    /**
     * Paginate a collection of resources.
     *
     * @param  array  $items
     *
     * @return array
     */
    public function paginateResources(array $items): array
    {
        return collect($items)
            ->put('data', $this->collection)
            ->put('links', $this->resource->links())
            ->all();
    }
}
