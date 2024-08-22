<?php

declare(strict_types=1);

namespace Nova\Menus\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Menus\Models\MenuItem;

class AddMenuItem extends SpotlightCommand
{
    protected string $name = 'Add Menu Item';

    protected string $description = 'Add a new menu item';

    protected array $synonyms = [
        'create menu item',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.menu-items.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', MenuItem::class);
    }
}
