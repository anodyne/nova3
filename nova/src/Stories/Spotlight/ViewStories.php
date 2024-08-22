<?php

declare(strict_types=1);

namespace Nova\Stories\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Stories\Models\Story;

class ViewStories extends SpotlightCommand
{
    protected string $name = 'View Stories';

    protected string $description = 'View the story timeline';

    protected array $synonyms = [
        'show story', 'view mission', 'show mission',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.stories.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Story::class);
    }
}
