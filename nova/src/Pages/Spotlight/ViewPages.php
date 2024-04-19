<?php

declare(strict_types=1);

namespace Nova\Pages\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Pages\Models\Page;

class ViewPages extends SpotlightCommand
{
    protected string $name = 'View Pages';

    protected string $description = 'View all pages';

    protected array $synonyms = [
        'show all pages',
        'display all pages',
        'list all pages',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('pages.index', ['tableFilters' => ['pageType' => ['value' => 0]]]);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Page::class);
    }
}
