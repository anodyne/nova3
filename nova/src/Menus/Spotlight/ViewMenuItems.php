<?php

declare(strict_types=1);

namespace Nova\Menus\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Menus\Models\MenuItem;

class ViewMenuItems extends SpotlightCommand
{
    protected string $name = 'View Menu Items';

    protected string $description = 'View all menu items';

    protected array $synonyms = [
        'show all menu items',
        'display all menu items',
        'list all menu items',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.menu-items.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', MenuItem::class);
    }
}
