<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewSystemDefaultsSettings extends SpotlightCommand
{
    protected string $name = 'System Defaults';

    protected string $description = "View Nova's system defaults settings";

    protected array $synonyms = [
        'presentation', 'theme', 'icon set', 'pulsar', 'titan', 'fluent',
        'look', 'skin',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.index', 'system-defaults');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
