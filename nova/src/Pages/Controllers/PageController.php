<?php

declare(strict_types=1);

namespace Nova\Pages\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
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

        $this->authorizeResource(Page::class);
    }

    public function index(): Responsable
    {
        return ListPagesResponse::send();
    }

    public function show(Page $page): Responsable
    {
        return ShowPageResponse::sendWith([
            'page' => $page,
        ]);
    }

    public function create(): Responsable
    {
        return CreatePageResponse::send();
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $page = CreatePageManager::run($request);

        if (Gate::allows('design', $page) && $page->is_basic) {
            return redirect()
                ->route('admin.pages.design', $page)
                ->notify("{$page->name} page was created");
        }

        return to_route('admin.pages.index')
            ->notify("{$page->name} page was created");
    }

    public function edit(Page $page): Responsable
    {
        return EditPageResponse::sendWith([
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $page = UpdatePageManager::run($page, $request);

        return back()->notify("{$page->name} page was updated");
    }
}
