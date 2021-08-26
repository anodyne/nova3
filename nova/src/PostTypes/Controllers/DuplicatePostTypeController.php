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

    public function __invoke(
        DuplicatePostType $action,
        PostType $originalPostType
    ) {
        $this->authorize('duplicate', $originalPostType);

        $postType = $action->execute($originalPostType);

        PostTypeDuplicated::dispatch($postType, $originalPostType);

        return redirect()
            ->route('post-types.edit', $postType)
            ->withToast("{$originalPostType->name} post type has been duplicated");
    }
}
