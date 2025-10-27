<?php

declare(strict_types=1);

namespace Nova\Addons\Controllers;

use Nova\Addons\Actions\CreateAddonManager;
use Nova\Addons\Actions\UpdateAddon;
use Nova\Addons\Models\Addon;
use Nova\Addons\Requests\StoreAddonRequest;
use Nova\Addons\Requests\UpdateAddonRequest;
use Nova\Addons\Responses\CreateAddonResponse;
use Nova\Addons\Responses\EditAddonResponse;
use Nova\Addons\Responses\ListAddonsResponse;
use Nova\Addons\Responses\ShowAddonResponse;
use Nova\Foundation\Controllers\Controller;

class AddonController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Addon::class);
    }

    public function index()
    {
        return ListAddonsResponse::send();
    }

    public function show(Addon $addon)
    {
        return ShowAddonResponse::sendWith([
            'addon' => $addon,
        ]);
    }

    public function create()
    {
        return CreateAddonResponse::send();
    }

    public function store(StoreAddonRequest $request)
    {
        $addon = CreateAddonManager::run($request);

        return to_route('admin.addons.index')
            ->notify(
                "{$addon->name} add-on was created",
                'A folder has been created in the addons directory to help you get started creating your add-on.'
            );
    }

    public function edit(Addon $addon)
    {
        return EditAddonResponse::sendWith([
            'addon' => $addon,
        ]);
    }

    public function update(UpdateAddonRequest $request, Addon $addon)
    {
        $addon = UpdateAddon::run($addon, $request->getAddonData());

        return to_route('admin.addons.edit', $addon)
            ->notify("{$addon->name} add-on was updated");
    }
}
