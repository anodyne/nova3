<?php

declare(strict_types=1);

namespace Nova\Users\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Users\Models\Ban;

class AddBan extends SpotlightCommand
{
    protected string $name = 'Add Ban';

    protected string $description = 'Add a new ban';

    /** @var list<string> */
    protected array $synonyms = [
        'create new ban',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.bans.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Ban::class);
    }
}
