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

class DesignPage extends SpotlightCommand
{
    protected string $name = 'Design Page';

    protected string $description = 'Update the design of a basic page';

    protected array $synonyms = [
        'build a page',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('page')
                    ->setPlaceholder('Which page do you want to design?')
            );
    }

    public function searchPage($query)
    {
        return Page::query()
            ->basic()
            ->searchFor($query)
            ->get()
            ->map(fn (Page $page) => new SpotlightSearchResult(
                $page->id,
                $page->name,
                $page->uri
            ));
    }

    public function execute(Spotlight $spotlight, Page $page): void
    {
        $spotlight->redirectRoute('admin.pages.design', $page);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('design', new Page);
    }
}
