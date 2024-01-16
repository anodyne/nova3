<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Filament\Forms\Form;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Nova\Foundation\Livewire\FormComponent;
use Nova\Pages\Blocks;
use Nova\Pages\Models\Page;

class PageDesigner extends FormComponent
{
    public Page $page;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TiptapEditor::make('blocks')
                    ->output(TiptapOutput::Json)
                    ->blocks([
                        Blocks\Hero\SimpleCenteredBlock::class,
                    ]),
            ])
            ->statePath('data')
            ->model($this->page);
    }

    public function save(): void
    {
        $this->page->update($this->form->getState());
    }

    public function mount(Page $page): void
    {
        $this->form->fill($page->toArray());
    }
}
