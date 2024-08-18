<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewEnvironmentSettings extends SpotlightCommand
{
    protected string $name = 'Environment Settings';

    protected string $description = "View Nova's environment settings";

    protected array $synonyms = [
        'smtp',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.environment.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
