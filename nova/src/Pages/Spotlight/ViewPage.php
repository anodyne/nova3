<?php

declare(strict_types=1);

namespace Nova\Pages\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Pages\Models\Page;

class ViewPage extends SpotlightCommand
{
    protected string $name = 'View Page';

    protected string $description = 'View a page';

    protected array $synonyms = [
        'show a page',
        'display a page',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('page')
                    ->setPlaceholder('Which page do you want to view?')
            );
    }

    public function searchRole($query)
    {
        return Page::query()
            ->searchFor($query)
            ->get()
            ->map(fn (Page $page) => new SpotlightSearchResult(
                $page->id,
                $page->uri,
                sprintf('View %s', $page->uri)
            ));
    }

    public function execute(Spotlight $spotlight, Page $page): void
    {
        $spotlight->redirectRoute('pages.show', $page);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new Page());
    }
}
