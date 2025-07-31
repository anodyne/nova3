<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Nova\Forms\Actions\PublishFormManager;
use Nova\Forms\Actions\UnpublishForm;
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormFieldsData;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Models\Form as NovaForm;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\FormComponent;

class FormDesigner extends FormComponent
{
    #[Locked]
    public NovaForm $novaForm;

    protected string $view = 'pages.forms.livewire.form-designer';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Builder::make('fields')
                    ->hiddenLabel()
                    ->blockPreviews(areInteractive: true)
                    ->blocks(FormFieldRegistry::fields())
                    ->collapsible()
                    ->addAction(function (Action $action): Action {
                        return $action
                            ->label('Add field')
                            ->icon(iconName('add'))
                            ->iconSize(IconSize::Medium)
                            ->slideOver()
                            ->modalWidth(MaxWidth::ExtraLarge);
                    })
                    ->editAction(function (Action $action): Action {
                        return $action
                            ->icon(iconName('settings'))
                            ->slideOver()
                            ->modalWidth(MaxWidth::ExtraLarge);
                    })
                    ->afterStateUpdated(fn () => $this->save()),
            ])
            ->statePath('data')
            ->model($this->novaForm);
    }

    public function save(): void
    {
        UpdateForm::run($this->novaForm, FormFieldsData::from($this->form->getState()));

        Notification::make()->success()
            ->title('Form design has been updated')
            ->body('This is an in progress draft and is not available for visitors and users to see and use until you have published it.')
            ->send();
    }

    public function publish(): void
    {
        PublishFormManager::run($this->novaForm);

        Notification::make()->success()
            ->title('Form design has been published')
            ->body('This version of the form is now live for all visitors and users to see and use.')
            ->send();
    }

    public function unpublish(): void
    {
        UnpublishForm::run($this->novaForm);

        Notification::make()->success()
            ->title('Form design has been un-published')
            ->body('This version of the form is no longer live.')
            ->send();
    }

    public function mount(NovaForm $novaForm): void
    {
        Cache::put('form-designer-form', $novaForm->id);

        $this->form->fill($novaForm->toArray());
    }

    #[Computed]
    public function getNovaForm(): NovaForm
    {
        return $this->novaForm;
    }
}
