<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Pages\Actions\CreatePageManager;
use Nova\Pages\Actions\UpdatePageManager;
use Nova\Pages\Models\Page;
use Nova\Pages\Requests\StorePageRequest;
use Nova\Pages\Requests\UpdatePageRequest;
use Nova\Pages\Responses\CreatePageResponse;
use Nova\Pages\Responses\EditPageResponse;
use Nova\Pages\Responses\ListPagesResponse;
use Nova\Pages\Responses\ShowPageResponse;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return ListPagesResponse::send();
    }

    public function show(Page $page)
    {
        return ShowPageResponse::sendWith([
            'page' => $page,
        ]);
    }

    public function create()
    {
        return CreatePageResponse::send();
    }

    public function store(StorePageRequest $request)
    {
        $page = CreatePageManager::run($request);

        if ($page->is_basic) {
            return redirect()
                ->route('admin.pages.design', $page)
                ->notify("{$page->name} page was created");
        }

        return redirect()
            ->route('admin.pages.index')
            ->notify("{$page->name} page was created");
    }

    public function edit(Page $page)
    {
        return EditPageResponse::sendWith([
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page = UpdatePageManager::run($page, $request);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->notify("{$page->name} page was updated");
    }
}
