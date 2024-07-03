<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Awcodes\Scribble\ScribbleEditor;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Cache;
use Nova\Forms\Actions\PublishForm;
use Nova\Forms\Actions\PublishFormManager;
use Nova\Forms\Actions\UpdateForm;
use Nova\Forms\Data\FormFieldsData;
use Nova\Forms\Models\Form as NovaForm;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\FormComponent;
use Nova\Foundation\Scribble\Profiles\FormBuilderProfile;

class FormDesigner extends FormComponent
{
    public NovaForm $novaForm;

    protected string $view = 'pages.forms.livewire.form-designer';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ScribbleEditor::make('fields')
                    ->hiddenLabel()
                    ->helperText("Type '/' to show a list of available fields to add to your form")
                    ->profile(FormBuilderProfile::class)
                    ->renderToolbar(),
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

    public function mount(NovaForm $novaForm): void
    {
        Cache::put('form-designer-form', $novaForm->id);

        $this->form->fill($novaForm->toArray());
    }
}
