<?php

declare(strict_types=1);

namespace Nova\Addons\Controllers;

use Illuminate\Http\RedirectResponse;
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
use Nova\Foundation\Responses\Responsable;

class AddonController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Addon::class);
    }

    public function index(): Responsable
    {
        return ListAddonsResponse::send();
    }

    public function show(Addon $addon): Responsable
    {
        return ShowAddonResponse::sendWith([
            'addon' => $addon,
        ]);
    }

    public function create(): Responsable
    {
        return CreateAddonResponse::send();
    }

    public function store(StoreAddonRequest $request): RedirectResponse
    {
        $addon = CreateAddonManager::run($request);

        return to_route('admin.addons.index')
            ->notify(
                "{$addon->name} add-on was created",
                'A folder has been created in the addons directory to help you get started creating your add-on.'
            );
    }

    public function edit(Addon $addon): Responsable
    {
        return EditAddonResponse::sendWith([
            'addon' => $addon,
        ]);
    }

    public function update(UpdateAddonRequest $request, Addon $addon): RedirectResponse
    {
        $addon = UpdateAddon::run($addon, $request->getAddonData());

        return to_route('admin.addons.edit', $addon)
            ->notify("{$addon->name} add-on was updated");
    }
}
