<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\Story;

class AddStory extends SpotlightCommand
{
    protected string $name = 'Add Story';

    protected string $description = 'Add a new story';

    protected array $synonyms = [
        'create story', 'add mission', 'create mission', 'add mission group',
        'create mission group',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.stories.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Story::class);
    }
}
