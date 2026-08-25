<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Illuminate\Http\RedirectResponse;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Roles\Models\Role;
use Nova\Stories\Actions\CreatePostType;
use Nova\Stories\Actions\UpdatePostType;
use Nova\Stories\Enums\PostEditTimeframe;
use Nova\Stories\Models\PostType;
use Nova\Stories\Requests\StorePostTypeRequest;
use Nova\Stories\Requests\UpdatePostTypeRequest;
use Nova\Stories\Responses\CreatePostTypeResponse;
use Nova\Stories\Responses\EditPostTypeResponse;
use Nova\Stories\Responses\ListPostTypesResponse;
use Nova\Stories\Responses\ShowPostTypeResponse;

class PostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(PostType::class, 'postType');
    }

    public function index(): Responsable
    {
        return ListPostTypesResponse::send();
    }

    public function show(PostType $postType): Responsable
    {
        return ShowPostTypeResponse::sendWith([
            'postType' => $postType->load('role')->loadCount('publishedPosts'),
        ]);
    }

    public function create(): Responsable
    {
        return CreatePostTypeResponse::sendWith([
            'editTimeframes' => PostEditTimeframe::toOptions(),
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function store(StorePostTypeRequest $request): RedirectResponse
    {
        $postType = CreatePostType::run($request->getPostTypeData());

        return to_route('admin.post-types.index')
            ->notify("{$postType->name} post type was created");
    }

    public function edit(PostType $postType): Responsable
    {
        return EditPostTypeResponse::sendWith([
            'editTimeframes' => PostEditTimeframe::toOptions(),
            'postType' => $postType,
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function update(UpdatePostTypeRequest $request, PostType $postType): RedirectResponse
    {
        $postType = UpdatePostType::run(
            $postType,
            $request->getPostTypeData()
        );

        return back()->notify("{$postType->name} post type was updated");
    }
}
