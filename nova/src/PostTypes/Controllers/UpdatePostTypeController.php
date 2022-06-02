<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\UpdatePostTypeRequest;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;
use Nova\Roles\Models\Role;

class UpdatePostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(PostType $postType)
    {
        $this->authorize('update', $postType);

        return UpdatePostTypeResponse::sendWith([
            'fieldTypes' => ['title', 'location', 'day', 'time', 'content', 'rating', 'summary'],
            'postType' => $postType,
            'roles' => Role::orderBySort()->get(),
        ]);
    }

    public function update(UpdatePostTypeRequest $request, PostType $postType)
    {
        $this->authorize('update', $postType);

        $postType = UpdatePostType::run(
            $postType,
            PostTypeData::from($request)
        );

        return redirect()
            ->route('post-types.edit', $postType)
            ->withToast("{$postType->name} post type was updated");
    }
}
