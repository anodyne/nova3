<?php

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\Story;

class CreateStory extends SpotlightCommand
{
    protected string $name = 'Create Story';

    protected string $description = 'Create a new story';

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('stories.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Story::class);
    }
}
