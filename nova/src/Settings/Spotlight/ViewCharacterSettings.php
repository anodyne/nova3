<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewCharacterSettings extends SpotlightCommand
{
    protected string $name = 'Character Settings';

    protected string $description = "View Nova's character settings";

    protected array $synonyms = [
        'character creation', 'link characters', 'approval', 'character limits',
        'automatic position availability',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.characters.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
