<?php

declare(strict_types=1);

namespace Nova\Menus\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Menus\Actions\CreateMenuItem;
use Nova\Menus\Actions\UpdateMenuItem;
use Nova\Menus\Models\MenuItem;
use Nova\Menus\Requests\StoreMenuItemRequest;
use Nova\Menus\Requests\UpdateMenuItemRequest;
use Nova\Menus\Responses\CreateMenuItemResponse;
use Nova\Menus\Responses\EditMenuItemResponse;
use Nova\Menus\Responses\ListMenuItemsResponse;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Page;

class MenuItemController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(MenuItem::class, 'menuItem');
    }

    public function index()
    {
        return ListMenuItemsResponse::send();
    }

    public function show(MenuItem $menuItem) {}

    public function create()
    {
        return CreateMenuItemResponse::sendWith([
            'pages' => Page::query()->public()->verb(PageVerb::get)->get(),
            'parentMenuItems' => MenuItem::whereNull('parent_id')->get(),
        ]);
    }

    public function store(StoreMenuItemRequest $request)
    {
        $menuItem = CreateMenuItem::run($request->getMenuItemData());

        return to_route('menu-items.index')
            ->notify("{$menuItem->label} menu item was created");
    }

    public function edit(MenuItem $menuItem)
    {
        return EditMenuItemResponse::sendWith([
            'menuItem' => $menuItem,
            'pages' => Page::query()->public()->verb(PageVerb::get)->get(),
            'parentMenuItems' => MenuItem::whereNull('parent_id')->where('id', '!=', $menuItem->id)->get(),
        ]);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem = UpdateMenuItem::run($menuItem, $request->getMenuItemData());

        return back()
            ->notify("{$menuItem->label} menu item has been updated");
    }
}
