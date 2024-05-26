<?php

declare(strict_types=1);

namespace Nova\Forms\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use Nova\Forms\Models\Form;

class ViewForms extends SpotlightCommand
{
    protected string $name = 'View Forms';

    protected string $description = 'View all forms';

    protected array $synonyms = [
        'show all forms',
        'display all forms',
        'list all forms',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('forms.index');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('viewAny', Form::class);
    }
}
