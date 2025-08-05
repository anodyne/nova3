<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Filament\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\FormComponent;
use Nova\Pages\Actions\PublishPage;
use Nova\Pages\Actions\UpdatePage;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Data\PageBlocksData;
use Nova\Pages\Models\Page;

class PageDesigner extends FormComponent
{
    #[Locked]
    public Page $page;

    protected string $view = 'pages.pages.livewire.page-designer';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Builder::make('blocks')
                    ->hiddenLabel()
                    ->blockPreviews(areInteractive: true)
                    ->blockPickerColumns(2)
                    ->blocks(PageBlockRegistry::blocks())
                    ->collapsible()
                    ->addAction(function (Action $action): Action {
                        return $action
                            ->label('Add block')
                            ->icon(Icon::Plus)
                            ->iconSize(IconSize::Medium)
                            ->slideOver()
                            ->modalWidth(Width::TwoExtraLarge);
                    })
                    ->editAction(function (Action $action): Action {
                        return $action
                            ->icon(Icon::Settings)
                            ->slideOver()
                            ->modalWidth(Width::TwoExtraLarge);
                    })
                    ->afterStateUpdated(fn () => $this->save()),
            ])
            ->statePath('data')
            ->model($this->page);
    }

    public function save(): void
    {
        UpdatePage::run($this->page, PageBlocksData::from($this->form->getState()));

        Notification::make()->success()
            ->title('Page design has been updated')
            ->body('This is an in progress draft and is not available for visitors and users to see until you have published it.')
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
