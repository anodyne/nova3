<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewRatingsSettings extends SpotlightCommand
{
    protected string $name = 'Content Ratings';

    protected string $description = "View Nova's content ratings settings";

    protected array $synonyms = [
        'language', 'sex', 'violence', 'content warnings', 'offensive', 'vulgar',
        'violent', 'mature',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.content-ratings.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
