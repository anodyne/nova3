<?php

declare(strict_types=1);

namespace Nova\Addons\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Addons\Models\Addon;

class ViewAddons extends SpotlightCommand
{
    protected string $name = 'View Add-ons';

    protected string $description = 'View all add-ons';

    /** @var array<int, string> */
    protected array $synonyms = [
        'show all add-ons',
        'show all extensions',
        'show all genres',
        'show all rank sets',
        'display all add-ons',
        'display all extensions',
        'display all genres',
        'display all rank sets',
        'list all add-ons',
        'list all extensions',
        'list all genres',
        'list all rank sets',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.addons.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Addon::class);
    }
}
