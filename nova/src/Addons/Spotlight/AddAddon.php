<?php

declare(strict_types=1);

namespace Nova\Addons\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Addons\Models\Addon;

class AddAddon extends SpotlightCommand
{
    protected string $name = 'Add Add-on';

    protected string $description = 'Add a new add-on';

    /** @var array<int, string> */
    protected array $synonyms = [
        'create new add-on',
        'create new extension',
        'create new genre',
        'create new rank set',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.addons.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Addon::class);
    }
}
