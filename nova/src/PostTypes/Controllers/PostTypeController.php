<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\CreatePostType;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\StorePostTypeRequest;
use Nova\PostTypes\Requests\UpdatePostTypeRequest;
use Nova\PostTypes\Responses\CreatePostTypeResponse;
use Nova\PostTypes\Responses\EditPostTypeResponse;
use Nova\PostTypes\Responses\ListPostTypesResponse;
use Nova\PostTypes\Responses\ShowPostTypeResponse;
use Nova\Roles\Models\Role;

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
            'fieldTypes' => $this->fieldTypes,
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function store(StorePostTypeRequest $request)
    {
        $postType = CreatePostType::run($request->getPostTypeData());

        return redirect()
            ->route('post-types.index')
            ->withToast("{$postType->name} post type was created");
    }

    public function edit(PostType $postType)
    {
        return EditPostTypeResponse::sendWith([
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
            ->withToast("{$postType->name} post type was updated");
    }
}
