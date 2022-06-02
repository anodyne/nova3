<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\DuplicatePostType;
use Nova\PostTypes\Events\PostTypeDuplicated;
use Nova\PostTypes\Models\PostType;

class DuplicatePostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(PostType $original)
    {
        $this->authorize('duplicate', $original);

        $postType = DuplicatePostType::run($original);

        PostTypeDuplicated::dispatch($postType, $original);

        return redirect()
            ->route('post-types.edit', $postType)
            ->withToast("{$original->name} post type was duplicated");
    }
}
