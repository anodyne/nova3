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

class EditStory extends SpotlightCommand
{
    protected string $name = 'Edit Story';

    protected string $description = 'Edit a story';

    protected array $synonyms = [
        'update story', 'update mission', 'edit mission', 'update mission group',
        'edit mission group',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('story')
                    ->setPlaceholder('Which story do you want to edit?')
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
                    sprintf('Edit %s', $story->title)
                );
            });
    }

    public function execute(Spotlight $spotlight, Story $story)
    {
        $spotlight->redirectRoute('admin.stories.edit', $story);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', new Story);
    }
}
