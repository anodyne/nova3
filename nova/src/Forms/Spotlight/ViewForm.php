<?php

declare(strict_types=1);

namespace Nova\Forms\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Forms\Models\Form;

class ViewForm extends SpotlightCommand
{
    protected string $name = 'View Form';

    protected string $description = 'View a form';

    protected array $synonyms = [
        'show a form',
        'display a form',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('form')
                    ->setPlaceholder('Which form do you want to view?')
            );
    }

    public function searchForm($query)
    {
        return Form::query()
            ->searchFor($query)
            ->get()
            ->map(fn (Form $form) => new SpotlightSearchResult(
                $form->id,
                $form->uri,
                sprintf('View %s', $form->key)
            ));
    }

    public function execute(Spotlight $spotlight, Form $form): void
    {
        $spotlight->redirectRoute('forms.show', $form);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('view', new Form());
    }
}
