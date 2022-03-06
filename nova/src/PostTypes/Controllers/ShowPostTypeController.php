<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Responses\ShowAllPostTypesResponse;
use Nova\PostTypes\Responses\ShowPostTypeResponse;

class ShowPostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        $this->authorize('viewAny', PostType::class);

        return ShowAllPostTypesResponse::send();
    }

    public function show(PostType $postType)
    {
        $this->authorize('view', $postType);

        return ShowPostTypeResponse::sendWith([
            'postType' => $postType,
        ]);
    }
}
