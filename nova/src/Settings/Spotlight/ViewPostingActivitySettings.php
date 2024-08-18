<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewPostingActivitySettings extends SpotlightCommand
{
    protected string $name = 'Posting Activity';

    protected string $description = "View Nova's posting activity settings";

    protected array $synonyms = [
        'story posts', 'post words', 'word count', 'per month', 'statistics',
        'stats', 'monthly', 'required', 'requirements', 'attribute', 'reporting',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.posting-activity.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
