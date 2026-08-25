<?php

declare(strict_types=1);

namespace Nova\Forms\Spotlight;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;
use Nova\Forms\Models\Form;

class DesignForm extends SpotlightCommand
{
    protected string $name = 'Design Form';

    protected string $description = 'Update the design of a form';

    /** @var array<string> */
    protected array $synonyms = [
        'build a form',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('form')
                    ->setPlaceholder('Which form do you want to design?')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchForm(string $query): Collection
    {
        return Form::query()
            ->searchFor($query)
            ->get()
            ->map(fn (Form $form): SpotlightSearchResult => new SpotlightSearchResult(
                $form->id,
                $form->name,
                $form->key
            ));
    }

    public function execute(Spotlight $spotlight, Form $form): void
    {
        $spotlight->redirectRoute('admin.forms.design', $form);
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('design', new Form);
    }
}
