<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Stories\Models\Story;

class ViewStory extends SpotlightCommand
{
    protected string $name = 'View Story';

    protected string $description = 'View a story';

    protected array $synonyms = [
        'show story', 'view mission', 'show mission', 'view mission group',
        'show mission group',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('story')
                    ->setPlaceholder('Which story do you want to view?')
            );
    }

    public function searchStory($query)
    {
        return Story::where('title', 'like', "%{$query}%")
            ->get()
            ->map(function ($story) {
                return new SpotlightSearchResult(
                    $story->id,
                    $story->title,
                    sprintf('Visit %s', $story->title)
                );
            });
    }

    public function execute(Spotlight $spotlight, Story $story)
    {
        $spotlight->redirectRoute('admin.stories.show', $story);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Story::class);
    }
}
