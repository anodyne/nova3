<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewGeneralSettings extends SpotlightCommand
{
    protected string $name = 'General Settings';

    protected string $description = "View Nova's general settings";

    protected array $synonyms = [];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.index', 'general');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
