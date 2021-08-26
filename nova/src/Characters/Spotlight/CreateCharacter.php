<?php

declare(strict_types=1);

namespace Nova\Characters\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Characters\Models\Character;

class CreateCharacter extends SpotlightCommand
{
    protected string $name = 'Create Character';

    protected string $description = 'Create a new character';

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('characters.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Character::class);
    }
}
