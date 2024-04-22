<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Awcodes\Scribble\ScribbleEditor;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\FormComponent;
use Nova\Foundation\Scribble\Profiles\PageBuilderProfile;
use Nova\Pages\Actions\PublishPage;
use Nova\Pages\Actions\UpdatePage;
use Nova\Pages\Models\Page;

class PageDesigner extends FormComponent
{
    public Page $page;

    protected string $view = 'pages.pages.livewire.page-designer';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ScribbleEditor::make('blocks')
                    ->label('')
                    ->helperText("Type '/' to show a list of available to blocks to add to your page")
                    ->profile(PageBuilderProfile::class),
            ])
            ->statePath('data')
            ->model($this->page);
    }

    #[On('saved-scribble-modal')]
    public function save(): void
    {
        UpdatePage::run($this->page, $this->form->getState());

        Notification::make()->success()
            ->title('Page design has been updated')
            ->body('This is an in progress draft and is not availble for visitors and users to see until you have published it.')
            ->send();
    }

    public function publish(): void
    {
        PublishPage::run($this->page);

        Notification::make()->success()
            ->title('Page design has been published')
            ->body('This version of the page is now live for all visitors and users to see.')
            ->send();
    }

    public function mount(Page $page): void
    {
        Cache::put('page-designer-page', $page->id);

        $this->form->fill($page->toArray());
    }
}
