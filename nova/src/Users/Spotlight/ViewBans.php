<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Users\Models\Ban;

class ViewBans extends SpotlightCommand
{
    protected string $name = 'View Bans';

    protected string $description = 'View all bans';

    /** @var list<string> */
    protected array $synonyms = [
        'show all bans',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.bans.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Ban::class);
    }
}
