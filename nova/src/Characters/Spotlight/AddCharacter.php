<?php

declare(strict_types=1);

namespace Nova\Characters\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Characters\Models\Character;

class AddCharacter extends SpotlightCommand
{
    protected string $name = 'Add Character';

    protected string $description = 'Add a new character';

    protected array $synonyms = [
        'create character',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.characters.create');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('create', Character::class);
    }
}
