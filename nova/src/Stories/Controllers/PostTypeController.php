<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
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
    protected $fieldTypes = [
        'title',
        'location',
        'day',
        'time',
        'content',
        'rating',
        'summary',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(PostType::class, 'postType');
    }

    public function index()
    {
        return ListPostTypesResponse::send();
    }

    public function show(PostType $postType)
    {
        return ShowPostTypeResponse::sendWith([
            'fieldTypes' => $this->fieldTypes,
            'postType' => $postType->load('role')->loadCount('publishedPosts'),
        ]);
    }

    public function create()
    {
        return CreatePostTypeResponse::sendWith([
            'editTimeframes' => PostEditTimeframe::toOptions(),
            'fieldTypes' => $this->fieldTypes,
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function store(StorePostTypeRequest $request)
    {
        $postType = CreatePostType::run($request->getPostTypeData());

        return redirect()
            ->route('post-types.index')
            ->notify("{$postType->name} post type was created");
    }

    public function edit(PostType $postType)
    {
        return EditPostTypeResponse::sendWith([
            'editTimeframes' => PostEditTimeframe::toOptions(),
            'fieldTypes' => $this->fieldTypes,
            'postType' => $postType,
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function update(UpdatePostTypeRequest $request, PostType $postType)
    {
        $postType = UpdatePostType::run(
            $postType,
            $request->getPostTypeData()
        );

        return redirect()
            ->route('post-types.edit', $postType)
            ->notify("{$postType->name} post type was updated");
    }
}
