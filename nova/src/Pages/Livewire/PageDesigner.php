<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Filament\Forms\Form;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Nova\Foundation\Blocks\BlockManager;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\FormComponent;
use Nova\Pages\Models\Page;

class PageDesigner extends FormComponent
{
    public Page $page;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TiptapEditor::make('blocks')
                    ->profile('none')
                    ->tools([
                        'blocks',
                    ])
                    ->output(TiptapOutput::Json)
                    ->blocks(app(BlockManager::class)->pageBlocks()),
            ])
            ->statePath('data')
            ->model($this->page);
    }

    public function save(): void
    {
        $this->page->update($this->form->getState());

        Notification::make()->success()
            ->title('Page design has been updated')
            ->send();
    }

    public function mount(Page $page): void
    {
        $this->form->fill($page->toArray());
    }
}
