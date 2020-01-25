<?php

namespace Nova\Themes\Http\Resources;

use Nova\Themes\Models\Theme;
use Nova\Foundation\Http\Resources\ResourceCollection;

class ThemeCollection extends ResourceCollection
{
    public $collects = ThemeResource::class;

    public function toArray($request)
    {
        return $this->paginateResources([
            'can' => [
                'create' => gate()->allows('create', Theme::class),
                'delete' => gate()->allows('delete', Theme::class),
                'update' => gate()->allows('update', Theme::class),
                'view' => gate()->allows('view', Theme::class),
            ],
        ]);
    }
}
